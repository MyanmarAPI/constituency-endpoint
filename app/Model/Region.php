<?php
/**
 * Region Model
 * 
 * @package App\Model
 * @author Li Jia Li <limonster.li@gmail.com>
 */

namespace App\Model;


class Region extends AbstractModel
{

    /**
     * Return mongo collection name to be connected
     *
     * <code>
     *     public function getCollectionName()
     *     {
     *         return 'user';
     *     }
     * </code>
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'region';
    }
}