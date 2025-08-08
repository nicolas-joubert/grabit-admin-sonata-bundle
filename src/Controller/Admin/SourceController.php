<?php

namespace NicolasJoubert\GrabitAdminSonataBundle\Controller\Admin;

use NicolasJoubert\GrabitAdminSonataBundle\Admin\SourceAdmin;
use NicolasJoubert\GrabitBundle\Grabber\Exceptions\CrawlerException;
use NicolasJoubert\GrabitBundle\Grabber\Exceptions\GrabException;
use NicolasJoubert\GrabitBundle\Grabber\Grabber;
use NicolasJoubert\GrabitBundle\Model\SourceInterface;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class SourceController extends AbstractController
{
    public function __construct(
        private readonly Grabber $grabber,
        private readonly TranslatorInterface $translator,
    ) {}

    /**
     * @param SourceAdmin<SourceInterface> $admin
     */
    public function grab(SourceAdmin $admin, Request $request): Response
    {
        $object = $admin->getSubject();

        $grabbedItems = [];
        $grabbedError = $grabbedDebug = '';

        try {
            $grabbedItems = $this->grabber->grabSource($object);
        } catch (\Exception $e) {
            $grabbedError = $e->getMessage();
            if ($e instanceof GrabException
                && $e->getPrevious() instanceof CrawlerException
                && $request->query->getBoolean('debug')
            ) {
                $grabbedDebug = 'Full HTML content crawled : '.$e->getPrevious()->getCrawler()?->html();
            }
        }

        return $this->render('@GrabitAdminSonata/Admin/Source/grab.html.twig', [
            'admin' => $admin,
            'action' => 'show',
            'object' => $object,
            'grabbedItems' => $grabbedItems,
            'grabbedError' => $grabbedError,
            'grabbedDebug' => $grabbedDebug,
        ]);
    }

    /**
     * @param SourceAdmin<SourceInterface>         $admin
     * @param ProxyQueryInterface<SourceInterface> $query
     */
    public function batchEnable(ProxyQueryInterface $query, SourceAdmin $admin): RedirectResponse
    {
        $admin->checkAccess('edit');

        try {
            $modelManager = $admin->getModelManager();

            /** @var array<SourceInterface> $selectedModels */
            $selectedModels = $query->execute();
            foreach ($selectedModels as $selectedModel) {
                $selectedModel->setEnabled(true);
                $modelManager->update($selectedModel);
            }

            $this->addFlash(
                'sonata_flash_success',
                $this->translator->trans('flash_batch_enable_success', [], $admin->getTranslationDomain())
            );
        } catch (\Exception) {
            $this->addFlash(
                'sonata_flash_error',
                $this->translator->trans('flash_batch_enable_error', [], $admin->getTranslationDomain())
            );
        } finally {
            return new RedirectResponse($admin->generateUrl('list', ['filter' => $admin->getFilterParameters()]));
        }
    }
}
