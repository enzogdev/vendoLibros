<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mensaje;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mensaje controller.
 *
 * @Route("mensaje")
 */
class MensajeController extends Controller
{
    /**
     * Lists all mensaje entities.
     *
     * @Route("/list/", name="mensaje_conversacion")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userReceptor = $em->getRepository('AppBundle:Usuario')->findOneByUsername($_GET['user']);

        $parameters = array('usuario' => $this->getUser(), 'usuarioReceptor' => $userReceptor);
        $query = $em->createQuery('SELECT n1
                                    FROM AppBundle\Entity\Mensaje n1
                                    WHERE n1.usuarioEmisor = :usuario
                                    AND n1.usuarioReceptor = :usuarioReceptor')
            ->setParameters($parameters);
        $query2 = $em->createQuery('SELECT n1
                                    FROM AppBundle\Entity\Mensaje n1
                                    WHERE n1.usuarioEmisor = :usuarioReceptor
                                    AND n1.usuarioReceptor = :usuario
                                    ')
            ->setParameters($parameters);
        $messajes = $query->execute();
        $messajes2 = $query2->execute();

        $messajesTotal = array_merge($messajes,$messajes2);
        usort($messajesTotal, function ($a, $b) {
            return $a->getId() - $b->getId();
        });

        $mensaje = new Mensaje();
        $userEmisor = $this->getUser();
        $userReceptor = $em->getRepository('AppBundle:Usuario')->findOneByUsername($_GET['user']);

        $form = $this->createForm('AppBundle\Form\MensajeType', $mensaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $fecha = new \DateTime();
            $mensaje->setFechaCreacion($fecha);
            $classUserEmisor = $em->getRepository('AppBundle:Usuario')->find($userEmisor);
            $mensaje->setUsuarioEmisor($classUserEmisor);
            $classUserReceptor = $em->getRepository('AppBundle:Usuario')->find($userReceptor);
            $mensaje->setUsuarioReceptor($classUserReceptor);
            $em->persist($mensaje);
            $em->flush();
        }



        return $this->render('mensaje/conversacion.html.twig', array(
            'mensajes' => $messajesTotal,
            'user'=> $this->getUser(),
            'userChat' => $_GET['user'],
            'form' =>$form->createView()
        ));
    }
    /**
     * Lists all contacts entities.
     *
     * @Route("/", name="mensaje_index")
     * @Method("GET")
     */
    public function ContactsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT IDENTITY(n1.usuarioEmisor)
                                    FROM AppBundle\Entity\Mensaje n1
                                    WHERE n1.usuarioReceptor = :usuario OR n1.usuarioEmisor = :usuario')
            ->setParameter('usuario',$this->getUser());
        $query1 = $em->createQuery('SELECT IDENTITY(n1.usuarioReceptor)
                                    FROM AppBundle\Entity\Mensaje n1
                                    WHERE n1.usuarioReceptor = :usuario OR n1.usuarioEmisor = :usuario')
            ->setParameter('usuario',$this->getUser());
        $usuariosTotal = array_merge($query->execute(), $query1->execute());
        $idArray = array();
        foreach ($usuariosTotal as $user){
            $idArray[] = $user[1];
        }
        $idArray = array_merge(array_diff(array_unique($idArray), array($this->getUser()->getId())));
        $userObject = array();
        for ($i = 0; $i <= count($idArray)-1; $i++) {
            $userObject[] = $em->getRepository('AppBundle:Usuario')->findOneById($idArray[$i]);
        }

        return $this->render('mensaje/index.html.twig', array(
            'usuarios' => $userObject,
        ));
    }
    /**
     * Creates a new mensaje entity.
     *
     * @Route("/new/ ", name="mensaje_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mensaje = new Mensaje();
        $userEmisor = $this->getUser();
        $userReceptor = $_GET['user'];
        $form = $this->createForm('AppBundle\Form\MensajeType', $mensaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $fecha = new \DateTime();
            $mensaje->setFechaCreacion($fecha);
            $classUserEmisor = $em->getRepository('AppBundle:Usuario')->find($userEmisor);
            $mensaje->setUsuarioEmisor($classUserEmisor);
            $classUserReceptor = $em->getRepository('AppBundle:Usuario')->findOneByUsername($userReceptor);
            $mensaje->setUsuarioReceptor($classUserReceptor);
            $em->persist($mensaje);
            $em->flush();

            return $this->redirectToRoute('mensaje_index');
        }

        return $this->render('mensaje/new.html.twig', array(
            'mensaje' => $mensaje,
            'form' => $form->createView(),
        ));
    }
}
