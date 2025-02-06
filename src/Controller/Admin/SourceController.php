<?php

namespace NicolasJoubert\GrabitAdminSonataBundle\Controller\Admin;

use NicolasJoubert\GrabitBundle\Grabber\Exceptions\CrawlerException;
use NicolasJoubert\GrabitBundle\Grabber\Exceptions\GrabException;
use NicolasJoubert\GrabitBundle\Grabber\Grabber;
use NicolasJoubert\GrabitBundle\Model\SourceInterface;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @phpstan-template T of SourceInterface
 *
 * @phpstan-extends CRUDController<T>
 */
class SourceController extends CRUDController
{
    public function __construct(readonly private Grabber $grabber) {}

    public function grab(int $id, Request $request): Response
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
            'action' => 'show',
            'object' => $object,
            'grabbedItems' => $grabbedItems,
            'grabbedError' => $grabbedError,
            'grabbedDebug' => $grabbedDebug,
        ]);
    }
}
