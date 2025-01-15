<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use League\Fractal\TransformerAbstract;
use Spatie\Fractal\Facades\Fractal;

trait ResponseTrait
{
    protected array $metaData = [];

    /**
     */
    public function transform(
        $data,
        $transformerName = null,
        array $includes = [],
        array $meta = [],
        $resourceKey = null,
    ): array {
        // first, we need to create the transformer
        if ($transformerName instanceof TransformerAbstract) {
            // check, if we have provided a respective TRANSFORMER class
            $transformer = $transformerName;
        } else {
            // of if we just passed the classname
            $transformer = new $transformerName();
        }

        // now, finally check, if the class is really a TRANSFORMER
        // if (!($transformer instanceof Transformer)) {
        //     // throw new InvalidTransformerException();
        // }

        // add specific meta information to the response message
        $this->metaData = array_merge($this->metaData, [
            'include' => $transformer->getAvailableIncludes(),
            'custom'  => $meta,
        ]);

        // // no resource key was set
        // if (! $resourceKey) {
        //     // get the resource key from the model
        //     if ($data instanceof AbstractPaginator) {
        //         $obj = $data->getCollection()->first();
        //     } elseif ($data instanceof Collection) {
        //         $obj = $data->first();
        //     } else {
        //         $obj = $data;
        //     }
        // }
        //
        // // Set Eager Load for resource
        // $defaultIncludes = $transformer->getDefaultIncludes();
        // foreach (array_merge($includes, $defaultIncludes) as $include) {
        //     if (method_exists($obj, $include) && method_exists($obj, 'load')) {
        //         $obj->load($include);
        //     }
        // }
        $fractal = Fractal::create($data, $transformer)->addMeta($this->metaData);

        // read includes passed via query params in url
        $requestIncludes = $this->parseRequestedIncludes();

        // merge the requested includes with the one added by the transform() method itself
        $requestIncludes = array_unique(array_merge($includes, $requestIncludes));

        // and let fractal include everything
        $fractal->parseIncludes($requestIncludes);

        // apply request filters if available in the request
        if ($requestFilters = Request::get('filter')) {
            $result = $this->filterResponse($fractal->toArray(), explode(';', $requestFilters));
        } else {
            $result = $fractal->toArray();
        }

        return $result;
    }

    protected function parseRequestedIncludes(): array
    {
        return explode(',', Request::get('include') ?? '');
    }

    private function filterResponse(array $responseArray, array $filters): array
    {
        foreach ($responseArray as $k => $v) {
            if (in_array($k, $filters, true)) {
                // we have found our element - so continue with the next one
                continue;
            }

            if (is_array($v)) {
                // it is an array - so go one step deeper
                $v = $this->filterResponse($v, $filters);
                if (empty($v)) {
                    // it is an empty array - delete the key as well
                    unset($responseArray[$k]);
                } else {
                    $responseArray[$k] = $v;
                }
            } elseif (! in_array($k, $filters)) {
                unset($responseArray[$k]);
            }
        }

        return $responseArray;
    }

    public function created($data = null, $status = 201, array $headers = [], $options = 0): JsonResponse
    {
        return new JsonResponse($data, $status, $headers, $options);
    }

    public function deleted(null|Model $deletedModel = null): JsonResponse
    {
        if (! $deletedModel) {
            return $this->accepted();
        }

        $id = $deletedModel->id;
        $className = (new \ReflectionClass($deletedModel))->getShortName();

        return $this->accepted([
            'message' => "$className ($id) Deleted Successfully.",
        ]);
    }

    public function accepted($data = null, $status = 202, array $headers = [], $options = 0): JsonResponse
    {
        return new JsonResponse($data, $status, $headers, $options);
    }

    public function noContent($status = 204): JsonResponse
    {
        return new JsonResponse(null, $status);
    }
}
