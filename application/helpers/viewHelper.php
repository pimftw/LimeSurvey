<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* LimeSurvey
* Copyright (C) 2007-2011 The LimeSurvey Project Team / Carsten Schmitz
* All rights reserved.
* License: GNU/GPL License v2 or later, see LICENSE.php
* LimeSurvey is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*
*	$Id$
*/

/**
 * General helper class for generating views.
 */
class viewHelper
{
    /**
     * getImageLink
     * Returns HTML needed for a link that consists of only an image with alt text.
     *
     * Usage: getImageLink('test.png', 'controller/action/params', 'Your description', 'optionalClass', '_blank')
     *
     * @param string $imgName the name of the image to use, adminImageUrl will be added to it
     * @param string $linkUrl Url we want to go to, uses CController->createUrl()
     * @param string $linkTxt Text to show for the link
     * @param string $linkTarget Optional target to use for the link
     * @param string $linkclass Optional class to add to the link
     * @param array  $attribs Optional array of attirbutes to set on the link
     */
    public static function getImageLink($imgName, $linkUrl, $linkTxt, $linkTarget = null, $linkClass = 'imagelink', $attribs = array())
    {
        if (!is_null($linkUrl) && $linkUrl != '#') {
            $linkUrl = Yii::app()->getController()->createUrl($linkUrl);
        } else {
            $linkUrl = "#";
        }
        $output = '<a href="' . $linkUrl;
        if (!empty($linkClass)) {
            $output .= '" class="' . $linkClass . '"';
        }
        if (!empty($linkTarget)) {
            $output .= ' target="' . $linkTarget . '"';
        }
        if (!empty($attribs)) {
            foreach($attribs as $attrib => $value) {
                $output .= ' ' . $attrib . '="' . str_replace('"', '&quot;', $value) . '"';
            }
        }
        $output .= '><img src="' . Yii::app()->getConfig('adminimageurl') . $imgName . '" alt="' . $linkTxt. '" title="' . $linkTxt. '"></a>';

        return $output;
    }

    /**
     * getFieldText
     * Returns $string : complete field information text for surveytable.
     *
     * Usage: getFieldText($q, $option)
     *
     * @param object $q the field information from createFieldMap
     * @param array $option option for filtering
     */
    public static function getFieldText($q, $option=false)
    {
        // Maybe put flatten in option
        if(isset($q->fieldname))
        {
            $questiontext=FlattenText($q->text,false,true);
            if(isset($q->scalename) && $q->scalename)
            {
                $questiontext.="[".FlattenText($q->scalename,false,true)."]";
            }
            if(isset($q->sq) && $q->sq)
            {
                $questiontext.="[".FlattenText($q->sq,false,true)."]";
            }
            if(isset($q->sq1) && $q->sq1)
            {
                $questiontext.="[".FlattenText($q->sq1,false,true)."]";
            }
            if(isset($q->sq2) && $q->sq2)
            {
                $questiontext.="[".FlattenText($q->sq2,false,true)."]";
            }
        }
        else
        {
            $questiontext="";
        }
        return $questiontext;
    }

    /**
     * getFieldCode
     * Returns $string : complete field information code for surveytable.
     *
     * Usage: getFieldCode($field, $option)
     *
     * @param object $q the field information from createFieldMap
     * @param array $option option for filtering
     */
    public static function getFieldCode($q, $option=false)
    {
        if(isset($q->fieldname))
        {
            if(isset($q->title) && $q->title)
            {
                $questioncode=$q->title;
                if(isset($q->scale))
                {
                    $scalenum=intval($q->scale)+1;
                    $questioncode.="[".$scalenum."]";
                }
                if(isset($q->aid) && $q->aid)
                {
                    $questioncode.="[".$q->aid."]";
                }
            }
            else
            {
                $questioncode=$q->fieldname;
            }
        }
        else
        {
            $questioncode="";
        }
        return $questioncode;
    }

}