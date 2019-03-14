<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
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
     * @Route("/about-us", name="about_us")
     */
    public function sobreNosotros(){
        return $this->render('sobreNosotros/about-us.html.twig');
    }
}
