<?php

/*
 * The MIT License
 *
 * Copyright 2014 Jacopo Galati <jacopo.galati@gmail.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Class with static helper methods to render HTML, ready to be used with the Bootstrap Framework.
 * 
 * @author Jacopo Galati <jacopo.galati@gmail.com>
 */
class BHtml
{

    /**
     * Return a value from an array of attributes and optionally removes it.
     * @param string $option Key of the attribute;
     * @param array $htmlOptions List of attributes;
     * @param boolean $unset If true unset the searched value from the list of attributes;
     * @return mixed
     */
    private static function getOption($option, &$htmlOptions, $unset = false)
    {
        if(isset($htmlOptions[$option]))
        {
            $value = $htmlOptions[$option];

            if($unset)
            {
                unset($htmlOptions[$option]);
            }
        }
        else
        {
            $value = null;
        }
        return $value;
    }

    /**
     * Append one or more classes to $htmlOptions.
     * @param mixed $class  It can be of two types:<br/>
     *                      <b>string</b>: name of the class to be added;
     *                      <b>array</b>: Key-value pair in which the key is the name of the class, and the vlue is an 
     *                      expression that determines if the class should be added;
     * @param array $htmlOptions    List of attributes;
     */
    private static function addClass($class, &$htmlOptions)
    {
        if(is_string($class))
        {
            $class = array($class => true);
        }

        foreach($class as $c => $exp)
        {
            if($exp === true)
            {
                $htmlOptions['class'] = isset($htmlOptions['class']) ? "{$htmlOptions['class']} $c" : $c;
            }
        }
    }

    /**
     * Add the corrent css classes for the column types and sizes.
     * @param array $sizes  Mixed array containing the sizes for different devices: the keys are constants of the 
     *                      column type and the value is the size;
     * @param type $htmlOptions List of attributes
     */
    private static function setColumns($sizes, &$htmlOptions)
    {
        if($sizes !== NULL)
        {
            $columnSizes = array('xs', 'sm', 'md', 'lg');
            foreach($sizes as $size => $n)
            {
                if($n <= 12 && in_array($size, $columnSizes))
                {
                    self::addClass("col-$size-$n", $htmlOptions);
                }
            }
        }
    }

    /**
     * Add the css classes for column the column offsets.
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              array <b>offset</b>: mixed array containing the offset for different screen devices:
     *                              the keys are constants of the column type (xs, sm, md, lg) and the value is the 
     *                              amount of the offset;
     */
    private static function setOffset(&$htmlOptions)
    {
        $offset = self::getOption('offset', $htmlOptions, true);
        $columnSizes = array('xs', 'sm', 'md', 'lg');
        if($offset !== null)
        {
            foreach($offset as $size => $n)
            {
                if(in_array($size, $columnSizes))
                {
                    self::addClass("col-$size-offset-$n", $htmlOptions);
                }
            }
        }
    }

    /**
     * Add the css classes for fixing the alignment of columns with different heights.
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              array <b>clearfix</b>: list of column types;
     */
    private static function setColumnReset($sizes, &$htmlOptions)
    {
        self::addClass('clearfix', $htmlOptions);

        $columnSizes = array('xs', 'sm', 'md', 'lg');
        foreach($sizes as $size)
        {
            if(in_array($size, $columnSizes))
            {
                self::addClass("visible-$size", $htmlOptions);
            }
        }
    }

    /**
     * Add the corrent css classes for the column types and sizes.
     * @param array $sizes  Mixed array containing the sizes for different devices: the keys are constants of the 
     *                      column type and the value is the size;
     * @param type $htmlOptions List of attributes
     */
    private static function setPush($sizes, &$htmlOptions)
    {
        $push = self::getOption('push', $htmlOptions, true);
        if($push !== null)
        {
            $columnSizes = array('xs', 'sm', 'md', 'lg');
            foreach($sizes as $size => $n)
            {
                if($n <= 12 && in_array($size, $columnSizes))
                {
                    self::addClass("col-$size-push-$n", $htmlOptions);
                }
            }
        }
    }

    /**
     * Add the corrent css classes for the column types and sizes.
     * @param array $sizes  Mixed array containing the sizes for different devices: the keys are constants of the 
     *                      column type and the value is the size;
     * @param type $htmlOptions List of attributes
     */
    private static function setColumnPull($sizes, &$htmlOptions)
    {
        $pull = self::getOption('pull', $htmlOptions, true);
        if($pull !== null)
        {
            $columnSizes = array('xs', 'sm', 'md', 'lg');
            foreach($sizes as $size => $n)
            {
                if($n <= 12 && in_array($size, $columnSizes))
                {
                    self::addClass("col-$size-pull-$n", $htmlOptions);
                }
            }
        }
    }

    /**
     * Set the quick float for an element.
     * @param type $htmlOptions
     */
    private static function setQuickPull(&$htmlOptions)
    {
        $pull = self::getOption('pull', $htmlOptions, true);

        if(in_array($pull, array('left', 'right')))
        {
            self::addClass(array("pull-$pull" => $pull !== null), $htmlOptions);
        }
    }

    /**
     * Set the checked attribute.
     * @param array $htmlOptions List of attributes;
     */
    private static function setChecked(&$htmlOptions)
    {
        if(self::getOption('checked', $htmlOptions, true) === true)
        {
            $htmlOptions['checked'] = 'checked';
        }
    }

    /**
     * Set the disabled attribute.
     * @param array $htmlOptions List of attributes;
     */
    private static function setDisabled(&$htmlOptions)
    {
        if(self::getOption('disabled', $htmlOptions, true) === true)
        {
            $htmlOptions['disabled'] = 'disabled';
        }
    }

    /**
     * Wrapper for CHtml::openTag().
     * @param string $tag   Name of the tag;
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function openTag($tag, $htmlOptions = array())
    {
        return self::tag($tag, $htmlOptions, false, false);
    }

    /**
     * Wrapper for CHtml::closeTag().
     * @param string $tag Name of the tag;
     * @return string
     */
    public static function closeTag($tag)
    {
        return CHtml::closeTag($tag);
    }

    /**
     * Wrapper for CHtml::tag().
     * @param string $tag   Name of the tag
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              string <b>backgroundState</b>: contextual color of the background, allowed values 
     *                              are: muted, primary, success, info, warning, danger;<br/>
     *                              boolean <b>center</b>: center a block element horizontally;<br/>
     *                              boolean <b>clearfix</b>: clear the float on the element;<br/>
     *                              mixed <b>hidden</b>: it can be an array with the sizes in which the element is 
     *                              visible (xs, sm, md, lg, print) or a boolean that determines if the element is hidden;<br/>
     *                              string <b>pull</b>: float the element, allowed values are: left, right;<br/>
     *                              boolean <b>screenReader</b>: determines if the element is visible to screen readers 
     *                              only;<br/>
     *                              string <b>textAlignment</b>: alignment of the text, allowed values are: left, center,
     *                              right, justify;<br/>
     *                              string <b>textState</b>: contextual color of the text, allowed values are: muted, 
     *                              primary, success, info, warning, danger;<br/>
     *                              boolean <b>textHide</b>: hides the text for image replacement;<br/>
     *                              mixed <b>visible</b>: it can be an array with the sizes in which the element is 
     *                              forced to show (xs, sm, md, lg, print) a boolean that determines if the element is 
     *                              shown;<br/>
     * @param string $content   It can be false if the tag does not have content;
     * @param boolean $closeTag Indicates if the tag has to be closed;
     * @return string
     */
    public static function tag($tag, $htmlOptions = array(), $content = false, $closeTag = true)
    {
        self::setVisibility($htmlOptions);

        self::setTextAlignment($htmlOptions);

        self::setQuickPull($htmlOptions);

        $classes = array(
            'center-block' => self::getOption('center', $htmlOptions, true) === true,
            'clearfix' => self::getOption('clearfix', $htmlOptions, true) === true,
            'text-hide' => self::getOption('textHide', $htmlOptions, true) === true,
            'sr-only' => self::getOption('screenReader', $htmlOptions, true) === true
        );
        self::addClass($classes, $htmlOptions);

        $options = array('text' => 'textState', 'bg' => 'backgroundState');
        foreach($options as $prefix => $option)
        {
            self::setStateStyle($prefix, $option, $htmlOptions);
        }

        return CHtml::tag($tag, isset($htmlOptions) ? $htmlOptions : array(), $content, $closeTag);
    }

    /**
     * Open a row container.
     * @param array $htmlOptions    List of attributes and other options<br/>
     *                              boolean <b>fluid</b>: enable a full-width container;<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function openContainer($htmlOptions = array())
    {
        $class = self::getOption('fluid', $htmlOptions, true) === true ? 'container-fluid' : 'container';
        self::addClass($class, $htmlOptions);

        return self::openTag('div', $htmlOptions);
    }

    /**
     * Close a row container.
     */
    public static function closeContainer()
    {
        return self::closeTag('div');
    }

    /**
     * Open a new row.
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function openRow($htmlOptions = array())
    {
        self::addClass('row', $htmlOptions);

        return self::openTag('div', $htmlOptions);
    }

    /**
     * Close a row.
     * @return string
     */
    public static function closeRow()
    {
        return self::closeTag('div');
    }

    /**
     * Create an image tag.
     * @param string $src   image url
     * @param array $htmlOptions    List of attributes and additional options:<br/>
     *                              boolean <b>responsive</b>: enable responsive images;<br/>
     *                              string <b>shape</b>: shape of the border, allowed values are: rounded, circle, 
     *                              thumbnail;<br/>
     *                              see {@link BHtml::tag()};<br/>
     * @return string
     */
    public static function image($src, $htmlOptions = array())
    {
        $htmlOptions['src'] = $src;

        self::addClass(array('img-responsive' => self::getOption('responsive', $htmlOptions, true)), $htmlOptions);

        return self::tag('img', $htmlOptions);
    }

    /**
     * Open a new column.
     * @param array $sizes  Mixed array containing the sizes for different devices: the keys are constants of the column
     *                      type and the value is the amount of them;
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              array <b>offset</b>: mixed array containing the offset for different screen devices:
     *                              the keys are constants of the column type and the value is the amount of the offset;
     *                              <br/>
     *                              array <b>reset</b>: contains the column types which need a reset (see
     *                              <a href="http://getbootstrap.com/css/#grid">Responsive column resets<a/>);
     *                              <br/>
     *                              array <b>push</b>: mixed array containing the offset to right for different column
     *                              types: the keys are constants of the column type and the value is the amount of
     *                              the push;<br/>
     *                              array <b>pull</b>: mixed array containing the offset to left for different column
     *                              types: the keys are constants of the column type and the value is the amount of the
     *                              pull;<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function openColumn($sizes, $htmlOptions = array())
    {
        self::setColumns($sizes, $htmlOptions);

        self::setOffset($htmlOptions);

        self::setPush($sizes, $htmlOptions);

        self::setColumnPull($sizes, $htmlOptions);

        return self::openTag('div', $htmlOptions);
    }

    /**
     * Close a column.
     * @return string
     */
    public static function closeColumn()
    {
        return self::closeTag('div');
    }

    /**
     * Create a div which fix the clear for columns with different heights.
     * @param array $sizes  List of column type constants with needs a reset;
     * @param array $htmlOptions    List of attributes;
     * @return string
     */
    public static function resetColumn($sizes, $htmlOptions = array())
    {
        self::setColumnReset($sizes, $htmlOptions);

        return self::tag('div', $htmlOptions, '');
    }

    /**
     * Create an heading tag
     * @param title $size   Size of the heading from 1 to 6;
     * @param string $content   content of the tag
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function heading($size, $content, $htmlOptions = array())
    {
        return self::tag('h' . min(array(abs($size), 6)), $htmlOptions, $content);
    }

    /**
     * Render an abbreviation tag.
     * @param string $content content of the tag;
     * @param string $title title shown on mouse hover;
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function abbreviation($content, $title, $htmlOptions = array())
    {
        $htmlOptions['title'] = $title;

        return self::tag('abbr', $htmlOptions, $content);
    }

    /**
     * Open an address tag.
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function openAddress($htmlOptions = array())
    {
        return self::openTag('address', $htmlOptions);
    }

    /**
     * Close an address tag.
     * @return string
     */
    public static function closeAddress()
    {
        return self::closeTag('address');
    }

    /**
     * Open a blockquote tag.
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function openBlockquote($htmlOptions = array())
    {
        return self::openTag('blockquote', $htmlOptions);
    }

    /**
     * Close a blockquote tag.
     * @return string
     */
    public static function closeBlockquote()
    {
        return self::closeTag('blockquote');
    }

    /**
     * Render a blockquote tag.
     * @param string $content Content of the blockquote
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              string <b>footer</b>: text identfying the source of the quote;<br/>
     *                              boolean <b>reverse</b>: enable the right alignment;
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function blockquote($content, $htmlOptions = array())
    {
        $footer = self::getOption('footer', $htmlOptions);

        self::addClass(array('blockquote-reverse' => self::getOption('reverse', $htmlOptions, true)), $htmlOptions);

        $render = self::openBlockquote($htmlOptions);

        $render.=self::tag('p', null, $content);

        if($footer !== null)
        {
            $render.=self::tag('footer', null, $footer);
        }

        $render.=self::closeBlockquote();

        return $render;
    }

    /**
     * Render the name of the source of a quote.
     * @param string $content Name of the source;
     * @param string $title Title of the source;
     * @param array $htmlOptions List of attributes;
     * @return string
     */
    public static function cite($content, $title, $htmlOptions = array())
    {
        $htmlOptions['title'] = $title;

        return self::tag('cite', $htmlOptions, $content);
    }

    /**
     * Open an unordered list tag.
     * @param array $htmlOptions    List of attributes and other options<br/>
     *                              boolean <b>unstyled</b>: disable the default style for this list;<br/>
     *                              boolean <b>inline</b>: render the items horizontally on a single row;<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function openUnorderedList($htmlOptions = array())
    {
        self::addClass(array('list-unstyled' => self::getOption('unstyled', $htmlOptions, true)), $htmlOptions);

        self::addClass(array('list-inline' => self::getOption('inline', $htmlOptions, true)), $htmlOptions);

        return self::openTag('ul', $htmlOptions);
    }

    /**
     * Close an unordered list tag.
     * @return string
     */
    public static function closeUnorderedList()
    {
        return self::closeTag('ul');
    }

    /**
     * Close an ordered list tag.
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              boolean <b>unstyled</b>: disable the default style for this list;<br/>
     *                              boolean <b>inline</b>: render the items horizontally on a single row;<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function openOrderedList($htmlOptions = array())
    {
        self::addClass('list-unstyled', $htmlOptions, self::getOption('unstyled', $htmlOptions, true));

        self::addClass('list-inline', $htmlOptions, self::getOption('unstyled', $htmlOptions, true));

        return self::openTag('ol', $htmlOptions);
    }

    /**
     * Close an ordered list tag.
     * @return string
     */
    public static function closeOrderedList()
    {
        return self::closeTag('ul');
    }

    /**
     * Open a description list
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              boolean <b>horizontal</b>: make terms and definitions like up side by side;
     * @return type
     */
    public static function openDescriptionList($htmlOptions = array())
    {
        self::addClass('dl-horizontal', $htmlOptions, self::getOption('horizontal', $htmlOptions, true));

        return self::openTag('dl', $htmlOptions);
    }

    /**
     * Render the term of a description list.
     * @param string $content Name of the term;
     * @param array $htmlOptions List of attributes;
     * @return string
     */
    public static function term($content, $htmlOptions = array())
    {
        return self::tag('dt', $htmlOptions, $content);
    }

    /**
     * Render the desscription of a term in a description list.
     * @param string $content Description of the term;
     * @param array $htmlOptions List of attributes;
     * @return string
     */
    public static function description($content, $htmlOptions = array())
    {
        return self::tag('dd', $htmlOptions, $content);
    }

    /**
     * Render an inline snippet of code, special chars in content will be converted in HTML entities.
     * @param type $content Content of the snippet;
     * @param type $htmlOptions List of attributes;
     * @return string
     */
    public static function code($content, $htmlOptions = array())
    {
        return self::tag('code', $htmlOptions, htmlspecialchars($content));
    }

    /**
     * Render an input that is typically entered by keyboard.
     * @param string $content Input to be rendered;
     * @param string $htmlOptions List of attributes;
     * @return string
     */
    public static function kbd($content, $htmlOptions = array())
    {
        return self::tag('kbd', $htmlOptions, $content);
    }

    /**
     * Render a multiline snippet of code.
     * @param string $content Code to be rendered;
     * @param array $htmlOptions List of attributes;
     * @return string
     */
    public static function pre($content, $htmlOptions = array())
    {
        return self::tag('pre', $htmlOptions, htmlspecialchars($content));
    }

    /**
     * Open a table.
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              boolean <b>bordered</b>: enable borders on all sides of the table and cells;
     *                              boolean <b>condensed</b>: cut the cell padding in half;
     *                              array <b>header</b>: List of header of the columns;
     *                              boolean <b>hover</b>: enable the hover effec on the rows of the table;
     *                              boolean <b>responsive</b>: make the table responsive;
     *                              boolean <b>striped</b>: enable the striped style for the rows;
     * @return string
     */
    public static function openTable($htmlOptions = array())
    {
        $header = self::getOption('header', $htmlOptions, true);

        self::addClass('table', $htmlOptions);

        $classes = array(
            'table-striped' => self::getOption('striped', $htmlOptions, true),
            'table-bordered' => self::getOption('bordered', $htmlOptions, true),
            'table-hover' => self::getOption('hover', $htmlOptions, true),
            'table-condensed' => self::getOption('condensed', $htmlOptions, true),
        );
        self::addClass($classes, $htmlOptions);

        if(self::getOption('responsive', $htmlOptions, true) === true)
        {
            $render = self::openTag('div', array('class' => 'table-responsive'));
        }
        else
        {
            $render = '';
        }

        $render.= self::openTag('table', $htmlOptions);

        if($header !== null)
        {
            $render.=self::openTag('thead');
            $render.=self::openTableRow();

            foreach($header as $h)
            {
                $render.=self::tag('th', array(), $h);
            }

            $render.=self::closeTableRow();
            $render.=self::closeTag('thead');
        }

        $render.=self::openTag('tbody');

        return $render;
    }

    /**
     * Close a table.
     * @param boolean $responsive Close the wrapper of a responsive table;
     * @return string
     */
    public static function closeTable($responsive = false)
    {
        $render = self::closeTag('tbody');

        $render.=self::closeTag('table');

        if($responsive === true)
        {
            $render.= self::closeTag('div');
        }

        return $render;
    }

    /**
     * Open a table row.
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              string <b>state</b>: set the contextual state of the row, allowed values are: active,
     *                              success, info, warning, danger;
     * @return string
     */
    public static function openTableRow($htmlOptions = array())
    {

        self::setStateStyle('tr', 'state', $htmlOptions);

        return self::openTag('tr', $htmlOptions);
    }

    public static function closeTableRow()
    {
        return self::closeTag('tr');
    }

    /**
     * Render a table cell.
     * @param string $content Content of the cell;
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              string <b>state</b>: set the contextual state of the cell, allowed values are: 
     *                              active, success, info, warning, danger;
     * @return string
     */
    public static function tableCell($content, $htmlOptions = array())
    {
        self::setStateStyle('td', 'state', $htmlOptions);

        return self::tag('td', $htmlOptions, $content);
    }

    /**
     * Render an input tag.
     * @param string $type Type of input;
     * @param string $name Name of the input;
     * @param string $htmlOptions   List of attribute and other options:<br/>
     *                              boolean <b>disabled</b>: disable the input;<br/>
     *                              string <b>inputSize</b>: make the input taller or shorter, allowed values are: sm, lg;<br/>
     *                              string <b>helpText</b>: help text for the input control;<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function input($type, $name, $htmlOptions = array())
    {
        $render = '';

        $helpText = self::getOption('helpText', $htmlOptions, true);

        $sizes = self::getOption('sizes', $htmlOptions, true);
        $offset = self::getOption('offset', $htmlOptions, true);

        $htmlOptions['type'] = $type;
        $htmlOptions['name'] = $name;

        self::setDisabled($htmlOptions);

        $inputSize = self::getOption('inputSize', $htmlOptions, true);
        self::addClass(array("input-$inputSize" => $inputSize !== null), $htmlOptions);

        if(!in_array($type, array('checkbox', 'radio', 'file')))
        {
            self::addClass('form-control', $htmlOptions);
        }

        if($sizes !== NULL)
        {
            $render.=self::openColumn($sizes, array('offset' => $offset !== NULL ? $offset : array()));
        }
        $render.= self::tag('input', $htmlOptions);
        if($helpText !== null)
        {
            $render.=self::tag('span', array('class' => 'help-block'), $helpText);
        }
        if($sizes !== NULL)
        {
            $render.=self::closeColumn();
        }

        return $render;
    }

    /**
     * Render a text area.
     * @param string $name Text area name;
     * @param string $value Text area value;
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              array <b>sizes</b>: mixed array containing the sizes for different devices: the keys
     *                               are the column type and the value is the size;
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function textArea($name, $value = '', $htmlOptions = array())
    {
        $sizes = self::getOption('sizes', $htmlOptions, true);

        $htmlOptions['name'] = $name;

        self::addClass('form-control', $htmlOptions);

        if($sizes !== NULL)
        {
            $render = self::openColumn($sizes);
        }
        else
        {
            $render = '';
        }

        $render.=self::tag('textarea', $htmlOptions, $value);

        if($sizes !== NULL)
        {
            $render.=BHtml::closeColumn();
        }

        return $render;
    }

    /**
     * Render a select input.
     * @param string $name Input name;
     * @param array $select Selected values;
     * @param array $data   Data for the list of options composed in one of these ways: (value => display), 
     *                      (group => (value => display));
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              boolean <b>multiple<b>: enable the selection of multiple values;<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function dropDownList($name, $select, $data, $htmlOptions = array())
    {
        if(self::getOption('multiple', $htmlOptions, true) === true)
        {
            $htmlOptions['multiple'] = 'multiple';
        }

        $htmlOptions['name'] = $name;

        self::addClass('form-control', $htmlOptions);

        $render = self::openTag('select', $htmlOptions);

        foreach($data as $group => $options)
        {
            if(is_array($options) === true)
            {
                $render.=self::openTag('optgroup', array('label' => $group));

                $render.=self::options($options, $select);

                $render.=self::closeTag('optgroup');
            }
            else
            {
                $render.=self::options(array($group => $options), $select);
            }
        }

        $render .= self::closeTag('select');

        return $render;
    }

    /**
     * Render an option tag.
     * @param array $data Array in which the keys are the option's value and the values are the option's label;
     * @param array $select Default selection of values;
     * @param array $htmlOptions List of attributes;
     * @return string
     */
    public static function options($data, $select = array())
    {
        $render = '';

        foreach($data as $value => $content)
        {
            $render.= self::openTag('option', array('value' => $value, 'selected' => in_array($value, $select)));
            $render.=$content;
            $render.=self::closeTag('option');
        }

        return $render;
    }

    /**
     * Open a form tag.
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              boolean <b>inline</b>: render an inline form;<br/>
     *                              boolean <b>horizontal</b>: render an form with labels and inputs aligned on the same line;<br/>
     *                              see {@link BHtml::tag()};
     */
    public static function openForm($htmlOptions = array())
    {

        $classes = array(
            'form-inline' => self::getOption('inline', $htmlOptions, true),
            'form-horizontal' => self::getOption('horizontal', $htmlOptions, true),
        );

        self::addClass($classes, $htmlOptions);

        return self::openTag('form', $htmlOptions);
    }

    /**
     * Close a form tag
     * @return string
     */
    public static function closeForm()
    {
        return self::closeTag('form');
    }

    /**
     * Create a lable tag.
     * @param string $label Text of the label
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              array <b>sizes</b>: mixed array containing the sizes for different devices: the keys
     *                               are the column type and the value is the size;
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function inputLabel($label, $htmlOptions = array())
    {
        self::addClass(array('control-label' => self::getOption('screenReader', $htmlOptions) !== true), $htmlOptions);

        self::setColumns(self::getOption('sizes', $htmlOptions, true), $htmlOptions);

        return self::tag('label', $htmlOptions, $label);
    }

    /**
     * Render a checkbox input.
     * @param string $name Input name;
     * @param string $value Input value;
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              boolean <b>checked</b>: mark the box as checked;<br/>
     *                              array <b>containerOptions</b>: list of attributes for the div surrounding;<br/>
     *                              boolean <b>inline</b>: render an inline checkbox (default is stacked);<br/>
     *                              string <b>label</b>: text of the checkbox label;<br/>
     *                              array <b>labelOptions</b>: list of attributes and other options for the label of inline checkboxes; ({@link BHtml::label()});<br/>
     *                              array <b>offset</b>: mixed array containing the offset for different screen devices:
     *                              the keys are constants of the column type and the value is the amount of the offset;
     *                              array <b>sizes</b>: mixed array containing the sizes for different devices: the keys
     *                               are the the column type and the value is the amount of them;<br/>
     *                              see {@link BHtml::input()};<br/>
     *                              see {@link BHtml::tag()};
     *                              <br/>
     * @return string
     */
    public static function checkBox($name, $value, $htmlOptions = array())
    {
        $render = '';

        $htmlOptions['value'] = $value;

        $sizes = self::getOption('sizes', $htmlOptions, true);

        $offset = self::getOption('offset', $htmlOptions, true);

        $containerOptions = self::getOption('containerOptions', $htmlOptions, true);

        $labelOptions = self::getOption('labelOptions', $htmlOptions, true);

        $inline = self::getOption('inline', $htmlOptions, true);

        $label = self::getOption('label', $htmlOptions, true);

        self::setChecked($htmlOptions);

        if($sizes !== null)
        {
            $render.=self::openColumn($sizes, array('offset' => $offset !== NULL ? $offset : array()));
        }

        if($inline !== true)
        {
            $containerOptions !== null ? $containerOptions : array();
            self::addClass('checkbox', $containerOptions);
            $render .= self::openTag('div', $containerOptions);
        }
        else
        {

            $labelOptions !== null ? $labelOptions : array();
            self::addClass('checkbox-inline', $labelOptions);
        }

        $render.=self::tag('label', $labelOptions, self::input('checkbox', $name, $htmlOptions) . $label);

        if($inline !== true)
        {
            $render.=self::closeTag('div');
        }

        if($sizes !== null)
        {
            $render.=self::closeColumn();
        }

        return $render;
    }

    /**
     * Render a file input filend.
     * @param string $name Input name;
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              see {@link BHtml::input()};<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function fileField($name, $htmlOptions = array())
    {
        return self::input('file', $name, $htmlOptions);
    }

    /**
     * Render a radio button input.
     * @param string $name Input name;
     * @param string $value Input value;
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              boolean <b>checked</b>: mark the button as checked;<br/>
     *                              array <b>containerOptions</b>: list of attributes for the div surrounding;<br/>
     *                              boolean <b>inline</b>: render an inline radio button (default is stacked);<br/>
     *                              string <b>label</b>: text of the checkbox label;<br/>
     *                              array <b>labelOptions</b>: list of attributes and other options for the label of inline radio buttons; ({@link BHtml::label()});<br/>
     *                              array <b>offset</b>: mixed array containing the offset for different screen devices:
     *                              the keys are constants of the column type and the value is the amount of the offset;
     *                              array <b>sizes</b>: mixed array containing the sizes for different devices: the keys
     *                               are the the column type and the value is the amount of them;<br/>
     *                              see {@link BHtml::input()};<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function radioButton($name, $value, $htmlOptions = array())
    {
        $render = '';

        $htmlOptions['value'] = $value;

        $sizes = self::getOption('sizes', $htmlOptions, true);

        $containerOptions = self::getOption('containerOptions', $htmlOptions, true);

        $labelOptions = self::getOption('labelOptions', $htmlOptions, true);

        $inline = self::getOption('inline', $htmlOptions, true);

        $label = self::getOption('label', $htmlOptions, true);

        self::setChecked($htmlOptions);

        if($sizes !== NULL)
        {
            $render.=self::openColumn($sizes, array('offset' => self::getOption('offset', $htmlOptions, true)));
        }

        if($inline !== true)
        {
            $containerOptions !== null ? $containerOptions : array();
            self::addClass('radio', $containerOptions);
            $render = self::openTag('div', $containerOptions);
        }
        else
        {
            $labelOptions !== null ? $labelOptions : array();
            self::addClass('radio-inline', $labelOptions);
        }

        $render.=self::tag('label', $labelOptions, self::input('radio', $name, $htmlOptions) . $label);

        if($inline !== true)
        {
            $render.=self::closeTag('div');
        }

        if($sizes !== null)
        {
            $render.=self::closeColumn();
        }

        return $render;
    }

    /**
     * Render a static control.
     * @param string $value value of the field;
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function staticControl($value, $htmlOptions = array())
    {
        self::addClass('form-control-static', $htmlOptions);

        return self::tag('p', $htmlOptions, $value);
    }

    /**
     * Open a fieldset tag.
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              boolean <b>disabled</b>: disable all the form controls inside the fieldset;<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function openFieldset($htmlOptions = array())
    {
        self::setDisabled($htmlOptions);

        return self::openTag('fieldset', $htmlOptions);
    }

    /**
     * Close a fieldset tag.
     * @return string
     */
    public static function closeFieldset()
    {
        return self::closeTag('fieldset');
    }

    /**
     * Open a form group.
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              string <b>state</b>: Validation state of the form group, it can have theese values:
     *                              success, warning, error;<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function openFormGroup($htmlOptions = array())
    {
        self::addClass('form-group', $htmlOptions);

        self::setStateStyle('has', 'state', $htmlOptions);

        return self::openTag('div', $htmlOptions);
    }

    /**
     * Close a form group.
     * @return string
     */
    public static function closeFormGroup()
    {
        return self::closeTag('div');
    }

    /**
     * Render a button tag.
     * @param string $content Content of the button;
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              boolean <b>active</b>: enable the active style of the button;<br/>
     *                              boolean <b>block</b>: make the button span the full width of its parent;<br/>
     *                              string <b>buttonState</b>: apply the selected style to the button, allowed values are:
     *                              default, primary, success, info, warning, danger, link;<br/>
     *                              string <b>buttonSize</b>: size of the button, allowed values are: lg, sm, xs;
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function button($content, $htmlOptions = array())
    {
        $htmlOptions['type'] = 'button';

        self::setbuttonState($htmlOptions);

        $size = self::getOption('buttonSize', $htmlOptions, true);
        self::addClass(array("btn-{$size}" => $size !== null), $htmlOptions);

        self::addClass(array("btn-block" => self::getOption('block', $htmlOptions, true)), $htmlOptions);

        self::addClass(array("active" => self::getOption('active', $htmlOptions, true)), $htmlOptions);

        return self::tag('button', $htmlOptions, $content);
    }

    /**
     * Render a link
     * @param string $content Text to display;
     * @param string $url Url of the link, it does not get encoded;
     * @param string $htmlOptions   List of attributes and other options:<br/>
     *                              boolean <b>active</b>: see {@link BHtml::button()};<br/>
     *                              string <b>buttonState</b>: see {@link BHtml::button()};<br/>
     *                              string <b>buttonSize</b>: see {#link BHtml::button()};<br/>
     *                              see {@link BHtml::tag()};
     * @return string
     */
    public static function link($content, $url, $htmlOptions = array())
    {
        $htmlOptions['href'] = $url;

        self::setbuttonState($htmlOptions);

        $size = self::getOption('buttonSize', $htmlOptions, true);
        self::addClass(array("btn-{$size}" => $size !== null), $htmlOptions);

        self::addClass(array("active" => self::getOption('active', $htmlOptions, true)), $htmlOptions);

        self::addClass(array("disabled" => self::getOption('disabled', $htmlOptions, true)), $htmlOptions);

        return self::tag('a', $htmlOptions, $content);
    }

    /**
     * Render a submit button.
     * @param string $content Content of the button;
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              boolean <b>active</b>: see {@link BHtml::button()};<br/>
     *                              string <b>buttonSize</b>: see {#link BHtml::button()};<br/>
     *                              string <b>buttonState</b>: see {@link BHtml::button()};<br/>
     *                              see {@link BHtml::tag()};
     * @return type
     */
    public static function submit($content, $htmlOptions = array())
    {
        $htmlOptions['type'] = 'submit';

        self::setbuttonState($htmlOptions);

        $size = self::getOption('buttonSize', $htmlOptions, true);
        self::addClass(array("btn-{$size}" => $size !== null), $htmlOptions);

        self::addClass(array("active" => self::getOption('active', $htmlOptions, true)), $htmlOptions);

        self::setDisabled($htmlOptions);

        return self::tag('button', $htmlOptions, $content);
    }

    /**
     * Apply the css style class.
     * @param type $prefix Prefix of the css class;
     * @param string $name Name of the option;
     * @param array $htmlOptions List of attributes;
     */
    private static function setStateStyle($prefix, $name, &$htmlOptions)
    {
        switch($prefix)
        {
            case 'bg':
                $allowedValues = array('primary', 'success', 'info', 'warning', 'danger');
                break;
            case 'btn':
                $allowedValues = array('default', 'primary', 'success', 'info', 'warning', 'danger', 'link');
                break;
            case 'has':
                $allowedValues = array('success', 'warning', 'error');
                break;
            case 'text':
                $allowedValues = array('muted', 'primary', 'success', 'info', 'warning', 'danger');
                break;
            case 'td':
            case 'tr':
                $allowedValues = array('active', 'success', 'info', 'warning', 'danger');
                $prefix = '';
                break;
            default:
                $allowedValues = array();
                break;
        }

        $name = self::getOption($name, $htmlOptions, true);
        if(in_array($name, $allowedValues))
        {
            if($prefix !== '')
            {
                $prefix.='-';
            }
            self::addClass("$prefix$name", $htmlOptions);
        }
    }

    /**
     * Set the selected button style.
     * @param array $htmlOptions List of attributes;
     */
    private static function setbuttonState(&$htmlOptions)
    {
        self::addClass('btn', $htmlOptions);

        self::setStateStyle('btn', 'buttonState', $htmlOptions);
    }

    /**
     * Set the visibility of the element through the css classes.
     * @param array $htmlOptions List of attributes;
     */
    private static function setVisibility(&$htmlOptions)
    {
        foreach(array('visible', 'hidden') as $state)
        {
            $visibility = self::getOption($state, $htmlOptions, true);
            if($visibility !== null)
            {
                if(is_array($visibility))
                {
                    $columnSizes = array('xs', 'sm', 'md', 'lg', 'print');
                    foreach($visibility as $size)
                    {
                        self::addClass(array("$state-$size" => in_array($size, $columnSizes)), $htmlOptions);
                    }
                }
                else
                {
                    $classes = array(
                        'show' => $visibility === true && $state === 'visible',
                        'hidden' => $visibility === true && $state === 'hidden',
                    );
                    self::addClass($classes, $htmlOptions);
                }
            }
        }
    }

    /**
     * Render a close button to dismiss content.
     * @param type $htmlOptions
     * @return type
     */
    public static function closeButton($htmlOptions = array())
    {
        $htmlOptions['aria-hidden'] = "true";
        $htmlOptions['type'] = 'button';

        self::addClass('close', $htmlOptions);

        return self::tag('button', $htmlOptions, '&times;');
    }

    /**
     * 
     * @param type $htmlOptions
     * @return type
     */
    public static function caret($htmlOptions = array())
    {
        self::addClass('caret', $htmlOptions);

        return self::tag('span', $htmlOptions, '');
    }

    /**
     * Render a glyphicon
     * @param string $values    Name of the icon (see {@link http://getbootstrap.com/components/#glyphicons-glyphs} for 
     *                          the full list;
     * @return string
     */
    public static function glyph($value)
    {
        return self::tag('span', array('class' => "glyphicon glyphicon-$value"), '');
    }

    /**
     * Open a button group.
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              string <b>buttonSize</b>: size of the button, allowed values are: lg, sm, xs;<br/>
     *                              boolean <b>vertical</b>: make the buttons appears stacked;
     * @return string
     */
    public static function openButtonGroup($htmlOptions = array())
    {
        self::addClass('btn-group', $htmlOptions);

        $size = self::getOption('buttonSize', $htmlOptions, true);
        self::addClass(array("btn-group-{$size}" => $size !== null), $htmlOptions);

        self::addClass(array("btn-group-justified" => self::getOption('justified', $htmlOptions, true) !== null), $htmlOptions);

        self::addClass(array("btn-group-vertical" => self::getOption('vertical', $htmlOptions, true) !== null), $htmlOptions);

        return self::openTag('div', $htmlOptions);
    }

    /**
     * Close a button group.
     * @return string
     */
    public static function closeButtonGroup()
    {
        return self::closeTag('div');
    }

    /**
     * Open a button toolbar.
     * @param array $htmlOptions    List of attributes;
     * @return string
     */
    public static function openButtonToolbar($htmlOptions = array())
    {
        $htmlOptions['role'] = 'toolbar';

        self::addClass('btn btn-toolbar', $htmlOptions);

        return self::openTag('div', $htmlOptions);
    }

    /**
     * Close a button toolbar.
     * @return string
     */
    public static function closeButtonToolbar()
    {
        return self::closeTag('div');
    }

    /**
     * Set the text alignment,
     * @param array $htmlOptions List of attributes;
     */
    public static function setTextAlignment(&$htmlOptions)
    {
        $alignment = self::getOption('textAlignment', $htmlOptions, true);
        if(in_array($alignment, array('left', 'center', 'right', 'justify')))
        {
            self::addClass("text-$alignment", $htmlOptions);
        }
    }

    /**
     * Render a list of checkboxes
     * @param string $name Name of the checkboxes, square brackes will be appended automatically;
     * @param array $select Selected values by default;
     * @param array $data Mixed array of data to populate the checkboes (label => value);
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              see {@link BHtml::checkbox()};
     * @return string
     */
    public static function checkBoxList($name, $select, $data, $htmlOptions = array())
    {
        $id = self::getOption('id', $htmlOptions, true);
        if($id === null)
        {
            $id = $name;
        }

        $i = 0;

        $render = '';

        foreach($data as $value => $label)
        {
            $htmlOptions['label'] = $label;
            $htmlOptions['id'] = "{$id}_{$i}";
            $htmlOptions['value'] = $value;

            if(in_array($value, $select) === true)
            {
                $htmlOptions['checked'] = true;
            }

            $render.=BHtml::checkBox("{$name}[]", $value, $htmlOptions);

            unset($htmlOptions['checked']);

            ++$i;
        }

        return $render;
    }

    /**
     * Render a group of radiobuttons.
     * @param string    $name           Name of the radiobuttons;
     * @param mixed     $select         Selected value by default;
     * @param array     $data           Mixed array of data to populate the checkboes (label => value);
     * @param array     $htmlOptions    List of attributes and other options:<br/>
     *                                      see {@link BHtml::checkbox()};
     * @return string
     */
    public static function radioButtonList($name, $select, $data, $htmlOptions = array())
    {
        $id = self::getOption('id', $htmlOptions, true);
        if($id === null)
        {
            $id = $name;
        }

        $i = 0;

        $render = '';

        foreach($data as $value => $label)
        {
            $htmlOptions['label'] = $label;
            $htmlOptions['id'] = "{$id}_{$i}";
            $htmlOptions['value'] = $value;

            if($value == $select)
            {
                $htmlOptions['checked'] = true;
            }

            $render.=BHtml::radioButton($name, $value, $htmlOptions);

            unset($htmlOptions['checked']);

            ++$i;
        }

        return $render;
    }

    /**
     * Render an input group.
     * @param string $name          Name attribute of the input tag.
     * @param mixed $value          Value of the input tag.
     * @param array $htmlOptions    List of attributes and other options:<br/>
     *                              string <b>prepend</b>: add-on to be appended;
     *                              string <b>prepend</b>: add-on to be prepended;
     *                              array <b>inputOptions</b>: list of attributes and other options of the input tag, 
     *                              see {@link BHtml::input()}.
     * @return string
     */
    public static function inputGroup($name, $value, $htmlOptions)
    {
        self::addClass('input-group', $htmlOptions);

        $inputOptions = self::getOption('inputOptions', $htmlOptions, true);
        $inputOptions['name'] = $name;
        $inputOptions['value'] = $value;

        $append = self::getOption('append', $htmlOptions, true);
        $prepend = self::getOption('prepend', $htmlOptions, true);

        $result = self::openTag('div', $htmlOptions);

        if($prepend !== NULL)
        {
            $result.=self::tag('span', array('class' => 'input-group-addon'), $prepend);
        }

        $result.=self::input('text', $name, $inputOptions);

        if($append !== NULL)
        {
            $result.=self::tag('span', array('class' => 'input-group-addon'), $append);
        }

        $result.=self::closeTag('div');

        return $result;
    }

    //TODO: input groups
    //TODO: navs
    //TODO: navbar
    //TODO: breadcrumb(check Yii breadcrumb widget)
    //TODO: pagination(check Yii pager widget)
    //TODO: badges
    //TODO: jumbotron
    //TODO: page header
    //TODO: thumbnails
    //TODO: alerts
    //TODO: progress bars
    //TODO: media objects
    //TODO: list groups
    //TODO: panels
    //TODO: wells
    //TODO: modals
    //TODO: scrollspy
    //TODO: tabs
    //TODO: tooltips
    //TODO: popovers
    //TODO: alerts
    //TODO: buttons (javascript)
    //TODO: collapse (javascript)
    //TODO: carousel (javascript)
    //TODO: affix;
}
