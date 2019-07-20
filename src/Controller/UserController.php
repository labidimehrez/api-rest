<?php

/**
 * @author Mehrez Labidi
 */

namespace App\Controller;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use App\Entity\Group;
use App\EntityManagers\UserManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use DateTime;
use App\Services\CacheHandler;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends Controller
{
    /**
     * @Route("/api/user/add", methods={"PUT"}, name="create_user")
     */
    public function postAddUser(Request $request, SerializerInterface $serializer)
    {
        $em = $this->getDoctrine()->getManager();
        $data =  $serializer->serialize($request->query->all(), 'json');
        $user = $serializer->deserialize($data, User::class, 'json');
        $em->persist($user);
        $em->flush();
        $result = "Success";

        return new JsonResponse($result);
    }

    /**
     * @Route("/api/user/deleteUserFromGroup/{user}/{group}", methods={"DELETE"}, name="delete_user_from_group")
     * @ParamConverter("user", class="App\Entity\User")
     * @ParamConverter("group", class="App\Entity\Group")
     */
    public function deleteUserFromGroup(User $user, Group $group, UserManager $userManager)
    {
        $result = $userManager->deleteUserFromGroup($user, $group);

        return new JsonResponse($result);
    }

    /**
     * @Route("/api/user/addUserToGroup/{user}/{group}", methods={"PUT"}, name="add_user_to_group")
     * @ParamConverter("user", class="App\Entity\User")
     * @ParamConverter("group", class="App\Entity\Group")
     */
    public function postUserToGroup(User $user, Group $group, UserManager $userManager)
    {
        $result = $userManager->addUserToGroup($user, $group);

        return new JsonResponse($result);
    }

    /**
     * @Route("/api/user/", methods={"GET"}, name="get_user")
     */
    public function getOneUser(Request $request, UserManager $userManager, CacheHandler $cacheHandler)
    {
        $users = $userManager->showUser($request);
        $data = $this->get('jms_serializer')->serialize($users, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($data);
        $response = $cacheHandler->setCacheResponse($response, $request);

        return $response;
    }

    /**
     * @Route("/api/groups/user/{user}", methods={"GET"}, name="get_groups_user")
     * @ParamConverter("user", class="App\Entity\User")
     */
    public function getAllGroupOneUser(Request $request, User $user, UserManager $userManager, CacheHandler $cacheHandler)
    {
        $groups = $userManager->showGroupsUser($user);
        $data = $this->get('jms_serializer')->serialize($groups, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($data);

        $response = $cacheHandler->setCacheResponse($response, $request);

        return $response;
    }

    /**
     * @Route("/api/user/list", methods={"GET"}, name="users_list")
     */
    public function getUsers(UserManager $userManager)
    {
        $users = $userManager->showAllUsers();
        $data = $this->get('jms_serializer')->serialize($users, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($data);
        $this->cacheSetting($response);

        return $response;
    }

    /**
     * @Route("/api/user/update/{user}", methods={"PUT"}, name="update_user")
     * @ParamConverter("user", class="App\Entity\User")
     */
    public function updateOneUser(Request $request, TranslatorInterface $translator, User $user, UserManager $userManager)
    {
        $result = $userManager->editUser($user, $request, $translator);
        return new JsonResponse($result);
    }

    /**
     * @Route("/api/user/delete/{user}", methods={"DELETE"}, name="delete_user" )
     * @ParamConverter("user", class="App\Entity\User")
     */
    public function deleteOneUser(User $user, UserManager $userManager)
    {
        $result = $userManager->deleteUser($user);
        return new JsonResponse($result);
    }
}
