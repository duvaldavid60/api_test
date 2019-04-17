<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Controller\ApiController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserGroup;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/api")
 */
class UserGroupController extends ApiController
{
    /**
     * @Route("/groups", methods={"GET"}, name="user_group_list")
     */
    public function listGroups()
    {
        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository(UserGroup::class)
        ->findAll();

        return $this->response($groups, Response::HTTP_OK, true);
    }

    /**
     * @Route("/group/{id}", methods={"GET"}, name="user_group_get")
     * @ParamConverter("id", class="\App\Entity\UserGroup")
     */
    public function getGroup(UserGroup $group)
    {
        return $this->response($group, Response::HTTP_OK, true);
    }

    /**
     * @Route("/group", methods={"POST"}, name="user_group_add")
     */
    public function addGroup(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $group = $this->serializer->deserialize($request->getContent(), UserGroup::class, 'json');
        $em->persist($group);
        $em->flush();

        return $this->response($group, Response::HTTP_CREATED);
    }

    /**
     * @Route("/group/{id}", methods={"POST"}, name="user_group_update")
     * @ParamConverter("id", class="\App\Entity\UserGroup")
     */
    public function updateGroup(Request $request, UserGroup $group)
    {
        $em = $this->getDoctrine()->getManager();
        $new = json_decode($request->getContent(), true);
        if (!isset($new['name']) || is_null($new['name'])) {
            return $this->response('Invalid object userGroup', Response::HTTP_BAD_REQUEST);
        }

        $group->setName($new['name']);
        $em->persist($group);
        $em->flush();
        return $this->response($group, Response::HTTP_OK);
    }

    /**
     * @Route("/group/{id}", methods={"DELETE"}, name="user_group_delete")
     * @ParamConverter("id", class="\App\Entity\UserGroup")
     */
    public function deleteGroup(UserGroup $group)
    {
        $groupId = $group->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($group);
        $em->flush();

        return $this->response("Group " . $groupId . " is deleted", Response::HTTP_OK);
    }

    /**
     * @Route("/group/{id}/user/{userId}", methods={"POST"}, name="user_group_add_user")
     * @ParamConverter("id", class="\App\Entity\UserGroup")
     * @ParamConverter("userId", class="\App\Entity\User", options={"mapping": {"userId" : "id"}})
     */
    public function addUsertoGroup(UserGroup $group, User $user)
    {
        $em = $this->getDoctrine()->getManager();

        try {
            $group->addUser($user);
        } catch (\Exception $exception) {
            return $this->response("Group : ". $group->getId(). " already contain User : ". $user->getId(), Response::HTTP_BAD_REQUEST);
        };

        $em->persist($group);
        $em->persist($user);
        $em->flush();

        return $this->response("User : ".$user->getId()." added to group:". $group->getId(), Response::HTTP_OK);
    }

    /**
     * @Route("/group/{id}/user/{userId}", methods={"DELETE"}, name="user_group_remove_user")
     * @ParamConverter("id", class="\App\Entity\UserGroup")
     * UserGroupController@ParamConverter("userId", class="\App\Entity\User", options={"mapping": {"userId" : "id"}})
     */
    public function removeUserFromGroup(UserGroup $group, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        try {
            $group->removeUser($user);
        } catch (\Exception $exception) {
            return $this->response("Group : ".$group->getId()."  dosen't contain User : ".$user->getId(), Response::HTTP_BAD_REQUEST);
        }
        $em->persist($user);
        $em->persist($group);
        $em->flush();

        return $this->response("User : ".$user->getId()."  remove from group :". $group->getId(), Response::HTTP_OK);
    }

    /**
     * @Route("/group/{id}/users", methods={"GET"}, name="user_group_list_users")
     * @ParamConverter("id", class="\App\Entity\UserGroup")
     */
    public function getGroupUsers(UserGroup $group)
    {
        $em = $this->getDoctrine()->getManager();

        return $this->response($group->getUsers(), Response::HTTP_OK, true);
    }
}
