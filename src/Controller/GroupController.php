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
use App\EntityManagers\GroupManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use DateTime;
use App\Services\CacheHandler;

class GroupController extends Controller
{

    /**
     * @Route("/api/group/add", methods={"PUT"}, name="create_group")
     */
    public function postAddGroup(Request $request, TranslatorInterface $translator, GroupManager $groupManager)
    {
        $result = $groupManager->addGroup($request, $translator);
        return new JsonResponse($result);
    }

    /**
     * @Route("/api/group/", methods={"GET"}, name="get_group")
     */
    public function getOneGroup(Request $request, GroupManager $groupManager)
    {
        $groups = $groupManager->showGroup($request);
        $data = $this->get('jms_serializer')->serialize($groups, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($data);
        $this->cacheSetting($response);
        return $response;
    }

    /**
     * @Route("/api/users/group/{group}", methods={"GET"}, name="get_users_group")
     * @ParamConverter("group", class="App\Entity\Group")
     */
    public function getAllUsersOneGroup(Request $request, Group $group, GroupManager $groupManager, CacheHandler $cacheHandler)
    {
        $users = $groupManager->showUsersGroup($group);
        $data = $this->get('jms_serializer')->serialize($users, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($data);
        $response = $cacheHandler->setCacheResponse($response, $request);
        return $response;
    }

    /**
     * @Route("/api/group/list", methods={"GET"}, name="groups_list")
     */
    public function getGroups(Request $request, GroupManager $groupManager, CacheHandler $cacheHandler)
    {
        $groups = $groupManager->showAllGroups();
        $data = $this->get('jms_serializer')->serialize($groups, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($data);
        $response = $cacheHandler->setCacheResponse($response, $request);
        return $response;
    }

    /**
     * @Route("/api/group/update/{group}", methods={"PUT"}, name="update_group")
     * @ParamConverter("group", class="App\Entity\Group")
     */
    public function updateOneGroup(Request $request, TranslatorInterface $translator, Group $group, GroupManager $groupManager)
    {
        $result = $groupManager->editGroup($group, $request, $translator);
        return new JsonResponse($result);
    }

    /**
     * @Route("/api/group/delete/{group}", methods={"DELETE"}, name="delete_group")
     * @ParamConverter("group", class="App\Entity\Group")
     */
    public function deleteOneGroup(Group $group, GroupManager $groupManager)
    {
        $result = $groupManager->deleteGroup($group);
        return new JsonResponse($result);
    }
}
