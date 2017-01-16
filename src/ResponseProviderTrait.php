<?php
/**
 * ResponseProviderTrait trait file.
 *
 * @package   Atan\Common
 * @author    atanvarno69 <https://github.com/atanvarno69>
 * @copyright 2017 atanvarno.com
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Atan\Common;

/** PSR-7 use block. */
use Psr\Http\Message\ResponseInterface;

/** PSR-17 use block. */
use Interop\Http\Factory\{
    ResponseFactoryInterface,
    StreamFactoryInterface
};

trait ResponseProviderTrait
{
    /**
     * @var ResponseFactoryInterface $responseFactory PSR-17 response factory.
     * @var StreamFactoryInterface   $streamFactory   PSR-17 stream factory.
     */
    protected $responseFactory, $streamFactory;
    
    /**
     * Provides a basic HTTP error response.
     *
     * @param int $code HTTP error code.
     *
     * @return ResponseInterface PSR-7 response.
     */
    protected function buildErrorResponse(int $code = 500): ResponseInterface
    {
        $response = $this->buildPrototypeResponse()
            ->withStatus($code)
            ->withHeader('Cache-Control', 'no-cache')
            ->withHeader('Content-Type', 'text/plain; charset=UTF-8');
        $body = (string) $code . ' ' . $response->getReasonPhrase();
        $response->getBody()->write($body);
        $response->getBody()->rewind();
        return $response->withHeader(
            'Content-Length',
            (string) $response->getBody()->getSize()
        );
    }
    
    /**
     * Provides a PSR-7 response with a readable, writable and seekable stream
     * body.
     *
     * @return ResponseInterface PSR-7 response.
     */
    protected function buildPrototypeResponse(): ResponseInterface
    {
        $stream = $this->getStreamFactory()->createStreamFromResource(
            fopen('php://temp', 'r+')
        );
        return $this->getResponseFactory()->createResponse()->withBody($stream);
    }
    
    /**
     * Provides a PSR-17 response factory.
     *
     * For use when `getPrototypeResponse()` does not fulfil your use case.
     *
     * @return ResponseFactoryInterface PSR-17 response factory.
     */
    protected function getResponseFactory(): ResponseFactoryInterface
    {
        return $this->responseFactory;
    }
    
    /**
     * Provides a PSR-17 stream factory.
     *
     * For use when `getPrototypeResponse()` does not fulfil your use case.
     *
     * @return StreamFactoryInterface PSR-17 stream factory.
     */
    protected function getStreamFactory(): StreamFactoryInterface
    {
        return $this->streamFactory;
    }
    
    /**
     * Set PSR-17 factories.
     *
     * Typically called from a constructor.
     *
     * @param ResponseFactoryInterface $responseFactory PSR-17 response factory.
     * @param StreamFactoryInterface   $streamFactory   PSR-17 stream factory.
     *
     * @return void
     */
    protected function setFactories(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
    }
}
