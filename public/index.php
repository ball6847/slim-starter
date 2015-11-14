<?php
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\NotFoundException;
use Doctrine\Common\Persistence\Mapping\MappingException;

$app = require(__DIR__.'/../application.php');

// -----------------------------------------------------
// handle GET /entity

$app->get('/{entity}[/]', function(Request $request, Response $response, $params = []) {
    try {
        $fqcn = "Model\\".$this->inflector->camelize($params['entity']);
        $entity = $this->doctrine->getRepository($fqcn);
        $data = $fqcn::collectionToArray($entity->findAll());
    } catch (MappingException $e) {
        throw new NotFoundException($request, $response);
    }

    return $this->jsonHandler($request, $response, $data);
});

// -----------------------------------------------------
// handle GET /entity/123

$app->get('/{entity}/{id}[/]', function(Request $request, Response $response, $params = []) {
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

    return $this->jsonHandler($request, $response, $data);
});

// -----------------------------------------------------
// handle POST /entity

$app->post('/{entity}[/]', function(Request $request, Response $response, $params = []) {
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
        return $this->badRequestHandler($request, $response);
    }

    return $this->jsonHandler($request, $response, $data);
});


// -----------------------------------------------------
// handle PUT /entity/123

$app->put('/{entity}/{id}[/]', function(Request $request, Response $response, $params = []) {
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
        return $this->badRequestHandler($request, $response);
    }

    return $this->jsonHandler($request, $response, $data);
});

// -----------------------------------------------------
// handle DELETE /entity/123

$app->delete('/{entity}/{id}[/]', function(Request $request, Response $response, $params = []) {
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
});

$app->run();
