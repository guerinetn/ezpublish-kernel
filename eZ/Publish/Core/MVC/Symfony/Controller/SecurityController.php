<?php
/**
 * File containing the SecurityControler class.
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\Core\MVC\Symfony\Controller;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Templating\EngineInterface;

class SecurityController
{
    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $templateEngine;

    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    protected $configResolver;

    /**
     * @var \Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface|null
     */
    protected $csrfProvider;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    public function __construct( EngineInterface $templateEngine, ConfigResolverInterface $configResolver, CsrfProviderInterface $csrfProvider = null )
    {
        $this->templateEngine = $templateEngine;
        $this->configResolver = $configResolver;
        $this->csrfProvider = $csrfProvider;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function setRequest( Request $request = null )
    {
        $this->request = $request;
    }

    public function loginAction()
    {
        $session = $this->request->getSession();

        if ( $this->request->attributes->has( SecurityContextInterface::AUTHENTICATION_ERROR ) )
        {
            $error = $this->request->attributes->get( SecurityContextInterface::AUTHENTICATION_ERROR );
        }
        else
        {
            $error = $session->get( SecurityContextInterface::AUTHENTICATION_ERROR );
            $session->remove( SecurityContextInterface::AUTHENTICATION_ERROR );
        }

        $csrfToken = isset( $this->csrfProvider ) ? $this->csrfProvider->generateCsrfToken( 'authenticate' ) : null;
        return new Response(
            $this->templateEngine->render(
                $this->configResolver->getParameter( 'security.login_template' ),
                array(
                    'last_username' => $session->get( SecurityContextInterface::LAST_USERNAME ),
                    'error' => $error,
                    'csrf_token' => $csrfToken,
                    'layout' => $this->configResolver->getParameter( 'security.base_layout' ),
                )
            )
        );
    }
}
