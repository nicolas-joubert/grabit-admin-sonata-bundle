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
    /**
     * @param SourceAdmin<SourceInterface>         $admin
     * @param ProxyQueryInterface<SourceInterface> $query
     */
    public function __construct(
        private readonly Grabber $grabber,
        private readonly TranslatorInterface $translator,
        private readonly SourceAdmin $admin,
        private readonly ProxyQueryInterface $query,
    ) {}

    public function grab(Request $request): Response
    {
        $object = $this->admin->getSubject();

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
            'admin' => $this->admin,
            'action' => 'show',
            'object' => $object,
            'grabbedItems' => $grabbedItems,
            'grabbedError' => $grabbedError,
            'grabbedDebug' => $grabbedDebug,
        ]);
    }

    public function batchEnable(): RedirectResponse
    {
        $this->admin->checkAccess('edit');

        try {
            $modelManager = $this->admin->getModelManager();

            /** @var array<SourceInterface> $selectedModels */
            $selectedModels = $this->query->execute();
            foreach ($selectedModels as $selectedModel) {
                $selectedModel->setEnabled(true);
                $modelManager->update($selectedModel);
            }

            $this->addFlash(
                'sonata_flash_success',
                $this->translator->trans('flash_batch_enable_success', [], $this->admin->getTranslationDomain())
            );
        } catch (\Exception) {
            $this->addFlash(
                'sonata_flash_error',
                $this->translator->trans('flash_batch_enable_error', [], $this->admin->getTranslationDomain())
            );
        } finally {
            return new RedirectResponse($this->admin->generateUrl('list', ['filter' => $this->admin->getFilterParameters()]));
        }
    }
}
