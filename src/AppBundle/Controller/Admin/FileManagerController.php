<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\FileManager;
use AppBundle\Form\UploadType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Finder;
/**
 * Class FileManagerController
 * @package AppBundle\Controller\Admin
 * @Route("/sa/file-manager")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class FileManagerController extends Controller {

    private $fileManager;
    protected function init($dir=null, $path=null){
        if($path){
            if($path[0]=="/"){
                $dir .= $path;
            }else{
                $dir .= "/".$path;
            }
        }
        $this->fileManager = new FileManager($dir);
        $finder = new Finder();
        $this->fileManager->currentDirectories(
            $finder->in($dir)->directories()
        );
        $finder = new Finder();
        $this->fileManager->currentDirectoryFiles(
            $finder->in($dir)->files()
        );
    }
    /**
     * @Route("/{dir}",
     *     name="app.admin.fileManager.index",
     *     defaults={ "dir":"uploads" }
     * )
     */
    public function indexAction(Request $request, $dir=null){
        $this->init($dir, $request->query->get("path"));
        $form = $this->createForm(UploadType::class, $this->fileManager)
            ->add('上传', SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->upload($this->fileManager);
        }

        return $this->render("Admin/FileManager/index.html.twig", [
            "fileManager" => $this->fileManager,
            'form'        => $form->createView(),
        ]);

    }

    public function upload(FileManager $fileManager){
        if( is_array($fileManager->getUploads()) ){
            foreach ( $fileManager->getUploads() as $upload ){
                $upload->move(
                    $fileManager->getCurrentPath(),
                    $upload->getClientOriginalName()
                );
            }
        }
        $this->init($fileManager->getCurrentPath());
    }

}