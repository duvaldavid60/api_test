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
class UserController extends ApiController
{

    /**
     * @Route("/users", methods={"GET"}, name="user_list")
     */
    public function listApiUsers(): Response
    {
        $user = $this->em->getRepository(User::class)
        ->findAll();

        return $this->response($user, Response::HTTP_OK, true);
    }

    /**
     * @Route("/user/{id}", methods={"GET"}, name="user_get")
     * @ParamConverter("id", class="\App\Entity\User")
     */
    public function getApiUser(User $user): Response
    {
        return $this->response($user, Response::HTTP_OK, true);
    }

    /**
     * @Route("/user", methods={"POST"}, name="user_add")
     */
    public function addApiUser(Request $request): Response
    {
        $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $this->em->persist($user);
        $this->em->flush();

        return $this->response($user, Response::HTTP_CREATED);
    }

    /**
     * @Route("/user/{id}", methods={"PUT"}, name="user_update")
     * @ParamConverter("id", class="\App\Entity\User")
     */
    public function updateApiUser(Request $request, User $user): Response
    {
        $new = json_decode($request->getContent(), true);
        if (!isset($new['name']) || !isset($new['password']) || is_null($new['name']) || is_null($new['password'])) {
            return $this->response('Invalid object user', Response::HTTP_BAD_REQUEST);
        }

        $user->setName($new['name']);
        $user->setPassword($new['password']);
        $this->em->persist($user);
        $this->em->flush();
        return $this->response($user, Response::HTTP_OK);
    }

    /**
     * @Route("/user/{id}", methods={"DELETE"}, name="user_delete")
     * @ParamConverter("id", class="\App\Entity\User")
     */
    public function deleteApiUser(User $user): Response
    {
        $userId = $user->getId();
        $this->em->remove($user);
        $this->em->flush();

        return $this->response("User " . $userId . " is deleted", Response::HTTP_OK);
    }

    /**
     * @Route("/user/{id}/groups", methods={"GET"}, name="user_list_groups")
     * @ParamConverter("id", class="\App\Entity\User")
     */
    public function getUserGroups(User $user): Response
    {
        return $this->response($user->getUserGroups(), Response::HTTP_OK, true);
    }
}
