<?php

namespace Sugarcrm\UpgradeSpec\Version\Graph;

use Sugarcrm\UpgradeSpec\Version\Version;

class Graph
{
    /**
     * @var AdjacencyList
     */
    private $graph;

    /**
     * @var array
     */
    private $visited = [];

    /**
     * Graph constructor.
     *
     * @param AdjacencyList $graph
     */
    public function __construct(AdjacencyList $graph)
    {
        $this->graph = $graph;
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
                if ($path = $this->breadthFirstSearch($origin, $destination)) {
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

        $first = $path[0];
        foreach (range(1, count($path) - 1) as $index) {
            $second = $path[$index];
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
     * Finds least number of hops (edges) between 2 nodes (vertices)
     * "breadth first" search
     *
     * @param Version $from
     * @param Version $to
     *
     * @return array
     */
    private function breadthFirstSearch(Version $from, Version $to)
    {

        // mark all nodes as unvisited
        foreach ($this->graph as $vertex => $adj) {
            $this->visited[$vertex] = false;
        }

        // create an empty queue
        $queue = new \SplQueue();

        // enqueue the origin vertex and mark as visited
        $queue->enqueue($from);
        $this->visited[(string) $from] = true;

        // this is used to track the path back from each node
        $path = [];
        $path[(string) $from] = new \SplDoublyLinkedList();
        $path[(string) $from]->setIteratorMode(
            \SplDoublyLinkedList::IT_MODE_FIFO | \SplDoublyLinkedList::IT_MODE_KEEP
        );

        $path[(string) $from]->push($from);

        // while queue is not empty and destination not found
        while (!$queue->isEmpty() && !$queue->bottom()->isEqualTo($to, false)) {
            $t = $queue->dequeue();

            if (!empty($this->graph[(string) $t])) {
                // for each adjacent neighbor
                foreach ($this->graph[(string) $t] as $vertex) {
                    if (!$this->visited[(string) $vertex]) {
                        // if not yet visited, enqueue vertex and mark as visited
                        $queue->enqueue($vertex);
                        $this->visited[(string) $vertex] = true;

                        // add vertex to current path
                        $path[(string) $vertex] = clone $path[(string) $t];
                        $path[(string) $vertex]->push($vertex);
                    }
                }
            }
        }

        if (!isset($path[(string) $to])) {
            return [];
        }

        return iterator_to_array($path[(string) $to]);
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
            return isset($this->graph[$version]);
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
            return isset($this->graph[$version]);
        });
    }
}
