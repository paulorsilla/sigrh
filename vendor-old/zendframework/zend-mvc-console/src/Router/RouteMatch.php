<?php
/**
 * @link      http://github.com/zendframework/zend-mvc-console for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Mvc\Console\Router;

use Zend\Router\RouteMatch as BaseRouteMatch;

class RouteMatch extends BaseRouteMatch
{
    /**
     * Length of the matched path.
     *
     * @var int
     */
    protected $length;

    /**
     * Create a RouteMatch with given parameters and length.
     *
     * @param  array   $params
     * @param  int $length
     */
    public function __construct(array $params, $length = 0)
    {
        parent::__construct($params);
        $this->length = $length;
    }

    /**
     * setMatchedRouteName(): defined by BaseRouteMatch.
     *
     * @see    BaseRouteMatch::setMatchedRouteName()
     * @param  string $name
     * @return self
     */
    public function setMatchedRouteName($name)
    {
        if ($this->matchedRouteName === null) {
            $this->matchedRouteName = $name;
            return $this;
        }

        $this->matchedRouteName = $name . '/' . $this->matchedRouteName;

        return $this;
    }

    /**
     * Merge parameters from another match.
     *
     * @param  RouteMatch $match
     * @return RouteMatch
     */
    public function merge(RouteMatch $match)
    {
        $this->params  = array_merge($this->params, $match->getParams());
        $this->length += $match->getLength();

        $this->matchedRouteName = $match->getMatchedRouteName();

        return $this;
    }

    /**
     * Get the matched path length.
     *
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }
}
