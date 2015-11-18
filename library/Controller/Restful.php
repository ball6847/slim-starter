<?php
namespace Library\Controller;

use Slim\Container;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\NotFoundException;
use Doctrine\Common\Persistence\Mapping\MappingException;

class Restful
{
    // --------------------------------------------------------------------

    /**
     * [__construct]
     *
     * @param EntityManager $doctrine  [description]
     * @param Inflector     $inflector [description]
     */
    public function __construct(Container $container)
    {
        $this->doctrine = $container['doctrine'];
        $this->inflector = $container['inflector'];
        $this->jsonHandler = $container['jsonHandler'];
        $this->badRequestHandler = $container['badRequestHandler'];
    }

    // --------------------------------------------------------------------

    /**
     * GET /entity
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @param  [type]   $params   [description]
     * @return [type]             [description]
     */
    public function index(Request $request, Response $response, Array $params)
    {
        try {
            $fqcn = "Model\\".$this->inflector->camelize($params['entity']);
            $entity = $this->doctrine->getRepository($fqcn);
            $data = $fqcn::collectionToArray($entity->findAll());
        } catch (MappingException $e) {
            throw new NotFoundException($request, $response);
        }

        return call_user_func($this->jsonHandler, $request, $response, $data);
    }

    // --------------------------------------------------------------------

    /**
     * GET /entity/123
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @param  [type]   $params   [description]
     * @return [type]             [description]
     */
    public function get(Request $request, Response $response, Array $params = [])
    {
        try {
            $name = "Model\\".$this->inflector->camelize($params['entity']);
            $entity = $this->doctrine->find($name, $params['id']);

            // record not found
            if (is_null($entity)) {
                throw new NotFoundException($request, $response);
            }

            $data = $entity->toArray();
        } catch (MappingException $e) {
            throw new NotFoundException($request, $response);
        }

        return call_user_func($this->jsonHandler, $request, $response, $data);
    }

    // --------------------------------------------------------------------

    /**
     * POST /entity/
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @param  [type]   $params   [description]
     * @return [type]             [description]
     */
    public function post(Request $request, Response $response, $params = [])
    {
        try {
            $input = $request->getParsedBody();
            $fqcn = "Model\\".$this->inflector->camelize($params['entity']);

            $entity = new $fqcn;
            $entity->fromArray($input);

            $this->doctrine->persist($entity);
            $this->doctrine->flush();

            $data = $entity->toArray();
        } catch (MappingException $e) {
            throw new NotFoundException($request, $response);
        } catch (Doctrine\DBAL\Exception\NotNullConstraintViolationException $e) {
            return call_user_func($this->badRequestHandler, $request, $response);
        }

        return call_user_func($this->jsonHandler, $request, $response, $data);
    }

    // --------------------------------------------------------------------

    /**
     * PUT /entity/123
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @param  [type]   $params   [description]
     * @return [type]             [description]
     */
    public function put(Request $request, Response $response, $params = [])
    {
        try {
            $input = $request->getParsedBody();
            $fqcn = "Model\\".$this->inflector->camelize($params['entity']);
            $entity = $this->doctrine->find($fqcn, $params['id']);

            // record not found
            if (is_null($entity)) {
                throw new NotFoundException($request, $response);
            }

            $entity->fromArray($input);

            $this->doctrine->persist($entity);
            $this->doctrine->flush();

            $data = $entity->toArray();
        } catch (MappingException $e) {
            throw new NotFoundException($request, $response);
        } catch (Doctrine\DBAL\Exception\NotNullConstraintViolationException $e) {
            return call_user_func($this->badRequestHandler, $request, $response);
        }

        return call_user_func($this->jsonHandler, $request, $response, $data);
    }

    // --------------------------------------------------------------------

    /**
     * DELETE /entity/123
     *
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @param  [type]   $params   [description]
     * @return [type]             [description]
     */
    public function delete(Request $request, Response $response, $params = [])
    {
        try {
            $fqcn = "Model\\".$this->inflector->camelize($params['entity']);
            $entity = $this->doctrine->find($fqcn, $params['id']);

            // record not found
            if (is_null($entity)) {
                throw new NotFoundException($request, $response);
            }

            $this->doctrine->remove($entity);
            $this->doctrine->flush();
        } catch (MappingException $e) {
            throw new NotFoundException($request, $response);
        }

        // 204 No Content
        return $response->withStatus(204);
    }
}
