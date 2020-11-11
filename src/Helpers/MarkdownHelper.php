<?php


namespace App\Helpers;


use cebe\markdown\Markdown;
//use Knp\Component\Pager\PaginatorInterface;
//use Symfony\Component\HttpFoundation\Request;

class MarkdownHelper
{
    public function parse($request, $paginator, $donnees)
    {
        $data = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1), // Numéro de passe en cours, 1 par défaut
            3
        );
        return $data;
    }
}