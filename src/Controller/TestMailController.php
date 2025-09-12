<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class TestMailController extends AbstractController
{
    #[Route('/test-email', name: 'app_test_email')]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('no-reply@example.com')
            ->to('you@example.com') // address doesn’t matter, Mailtrap catches it
            ->subject('Test email from Symfony')
            ->text('If you see this, Mailtrap is working!');

        $mailer->send($email);

        return new Response('Email sent, check Mailtrap inbox');
    }
}
