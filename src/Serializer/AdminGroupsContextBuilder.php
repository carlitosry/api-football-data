<?php

namespace App\Serializer;

use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator('api_platform.serializer.context_builder')]
readonly class AdminGroupsContextBuilder implements SerializerContextBuilderInterface
{
    public function __construct(
        private SerializerContextBuilderInterface $decorated,
        private Security $security
    )
    {
    }

    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);

        if ($this->security->isGranted('ROLE_ADMIN')) {
            if (!isset($context['groups'])) {
                $context['groups']= [];
            }

            $context['groups'][] = $normalization ? 'admin:read' : 'admin:write';
        }

        return $context;
    }

}