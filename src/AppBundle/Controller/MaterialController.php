<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Material;
use AppBundle\Entity\MaterialHasCategoria;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Material controller.
 *
 * @Route("material")
 */
class MaterialController extends Controller
{
    /**
     * Lists all material entities.
     *
     * @Route("/", name="material_index")
     * @Method("GET")
     */
    public function indexAction( Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $catsForm = $request->get('categorias'); //(ID) Categorias seleccionadas por el usuario
        $materials = ''; //Lista de Objetos Material que se pasa a la template
        $array = array();
        $categories = $em->getRepository('AppBundle:Categoria')->findBy(array(),array('nombre'=>'ASC'));

        if ($catsForm) {
            $categorys = $em->getRepository('AppBundle:MaterialHasCategoria')->findBy(array('categoria' => $catsForm)); //Recojo el enlace entre los materiales y categorias
            foreach ($categorys as $catt){
                $array[] = $catt->getMaterial();
            }
            $materials = $em->getRepository('AppBundle:Material')->findBy(
                array('id' => $array)
            );
        } else {
            $materials = $em->getRepository('AppBundle:Material')->findAll();
        }

        return $this->render('material/index.html.twig', array(
            'materials' => $materials,
            'categorias' => $categories,
        ));
    }

    /**
     * Creates a new material entity.
     *
     * @Route("/new", name="material_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        $material = new Material();
        $form = $this->createForm('AppBundle\Form\MaterialType', $material);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        $categorias = $em->getRepository('AppBundle:Categoria')->findAll();

        if ($form->isSubmitted() && $form->isValid()) {

            $imagenes = $material->getImagenes();
            $imagesName = array();
            foreach( $imagenes as $imagen){
                $imagenName = md5(uniqid()).'.'.$imagen->guessExtension();
                $imagesName[] = $imagenName;
                $imagenDir = $this->container->getparameter('kernel.root_dir').'/../web/images/material';
                $imagen->move($imagenDir, $imagenName);
            }
            $material->setImagenes(implode(',',$imagesName));

            $em = $this->getDoctrine()->getManager();
            $classUser = $em->getRepository('AppBundle:Usuario')->find($user);
            $material->setUsuario($classUser);
            $fecha = new \DateTime();
            $material->setFechaPublicacion($fecha);
            $em->persist($material);
            $em->flush();

            $arrayCat = $_REQUEST['tag'];

            foreach ($arrayCat as  $cat){
                $categ = $em->getRepository('AppBundle:Categoria')->findOneById($cat);
                $materialCat = new MaterialHasCategoria();
                $materialCat->setCategoria($categ);
                $materialCat->setMaterial($material);
                $em->persist($materialCat);
                $em->flush();
            }
            return $this->redirectToRoute('material_show', array('id' => $material->getId()));
        }

        return $this->render('material/new.html.twig', array(
            'material' => $material,
            'categorias' => $categorias,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a material entity.
     *
     * @Route("/{id}", name="material_show")
     * @Method("GET")
     */
    public function showAction(Material $material)
    {
        $deleteForm = $this->createDeleteForm($material);

        return $this->render('material/show.html.twig', array(
            'material' => $material,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing material entity.
     *
     * @Route("/{id}/edit", name="material_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Material $material)
    {
        $deleteForm = $this->createDeleteForm($material);
        $editForm = $this->createForm('AppBundle\Form\MaterialType', $material);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $imagenes = $material->getImagenes();
            $imagesName = array();
            foreach( $imagenes as $imagen){
                $imagenName = md5(uniqid()).'.'.$imagen->guessExtension();
                $imagesName[] = $imagenName;
                $imagenDir = $this->container->getparameter('kernel.root_dir').'/../web/images/material';
                $imagen->move($imagenDir, $imagenName);
            }
            $material->setImagenes(implode(',',$imagesName));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('material_edit', array('id' => $material->getId()));
        }

        return $this->render('material/edit.html.twig', array(
            'material' => $material,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a material entity.
     *
     * @Route("/material/{id}/edit", name="material_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Material');
        $material = $repository->find($id);

        $form = $this->createDeleteForm($material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($material);
            $em->flush();
        }

        return $this->redirectToRoute('material_index');
    }

    /**
     * Creates a form to delete a material entity.
     *
     * @param Material $material The material entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Material $material)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('material_delete', array('id' => $material->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}
