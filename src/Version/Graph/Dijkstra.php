<?php

namespace Sugarcrm\UpgradeSpec\Version\Graph;

use Sugarcrm\UpgradeSpec\Version\Version;

class Dijkstra
{
    /**
     * @var array
     */
    private $graph;

    /**
     * Graph constructor.
     *
     * @param AdjacencyList $adj
     */
    public function __construct(AdjacencyList $adj)
    {
        foreach ($adj as $vertex => $list) {
            $list = array_map(function (Version $version) use ($vertex) {
                return [(string) $version => (new Version($vertex))->isChildOf($version) ? 0 : 1];
            }, iterator_to_array($list));

            $this->graph[(string) $vertex] = $list ? call_user_func_array('array_merge', $list) : [];
        }
    }

    /**
     * @param Version $from
     * @param Version $to
     *
     * @return array
     */
    public function getPath(Version $from, Version $to)
    {
        $destinations = $this->getDestinationVertexes($to);
        foreach ($this->getOriginVertexes($from) as $origin) {
            foreach ($destinations as $destination) {
                if ($path = $this->getShortestPath((string) $origin, (string) $destination)) {
                    return $this->getRealHops($path);
                }
            }
        }

        return [];
    }

    /**
     * @param $path
     *
     * @return array
     */
    private function getRealHops($path)
    {
        $pairs = [];

        $first = new Version($path[0]);
        foreach (range(1, count($path) - 1) as $index) {
            $second = new Version($path[$index]);
            if ($first->isChildOf($second)) {
                $first = $second;
                continue;
            }

            $pairs[] = [$first, $second];

            $first = $second;
        }

        return $pairs;
    }

    /**
     * Dijkstra "the shortest path" algorithm
     *
     * @param $source
     * @param $target
     *
     * @return array
     */
    private function getShortestPath($source, $target)
    {
        // array of the best estimates of shortest path to each vertex
        $bestEstimates = [];
        // array of predecessors for each vertex
        $predecessors = [];
        // queue of all unoptimized vertices
        $queue = new \SplPriorityQueue();

        foreach ($this->graph as $vertex => $list) {
            $bestEstimates[$vertex] = \INF; // set initial distance to "infinity"
            $predecessors[$vertex] = null; // no known predecessors yet
            foreach ($list as $w => $cost) {
                // use the edge cost as the priority
                $queue->insert($w, $cost);
            }
        }

        // initial distance at source is 0
        $bestEstimates[$source] = 0;

        while (!$queue->isEmpty()) {
            // extract min cost
            $u = $queue->extract();
            if (!empty($this->graph[$u])) {
                // "relax" each adjacent vertex
                foreach ($this->graph[$u] as $vertex => $cost) {
                    // alternate route length to adjacent neighbor
                    $alt = $bestEstimates[$u] + $cost;
                    /**
                     * if alternate route is shorter:
                     * - update minimum length to vertex
                     * - add neighbor to predecessors for vertex
                     */
                    if ($alt < $bestEstimates[$vertex]) {
                        $bestEstimates[$vertex] = $alt;
                        $predecessors[$vertex] = $u;

                        $queue->insert($vertex, $cost);
                    }
                }
            }
        }

        // we can now find the shortest path using reverse iteration
        $stack = new \SplStack();
        $u = $target;
        while (isset($predecessors[$u]) && $predecessors[$u]) {
            $stack->push($u);
            $u = $predecessors[$u];
        }

        // there is no route back
        if ($stack->isEmpty()) {
            return [];
        }

        // add the source node
        $stack->push($source);

        return iterator_to_array($stack, false);
    }

    /**
     * @param Version $from
     *
     * @return OrderedList
     */
    private function getOriginVertexes(Version $from)
    {
        $aliases = $from->getAliases();
        while ($from->isMinor()) {
            $from = $from->getParent();
            $aliases = $aliases->merge($from->getAliases());
        }

        return $aliases->filter(function (Version $version) {
            return isset($this->graph[(string) $version]);
        });
    }

    /**
     * @param Version $to
     *
     * @return OrderedList
     */
    private function getDestinationVertexes(Version $to)
    {
        return $to->getAliases()->filter(function (Version $version) {
            return isset($this->graph[(string) $version]);
        });
    }
}
