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
 * This component register the package containing the Bootstrap framework assets.
 * By default, the assets will be loaded internally or by the cdn, alternately can be provided a custom path.
 *
 * @author Jacopo Galati <jacopo.galati@gmail.com>
 */
class Bootstrap extends CApplicationComponent
{

    /**
     * Indicates if the assets are loaded from Bootstrap CDN
     * @var boolean
     */
    public $useCDN = false;

    /**
     * Bootstrap framework version
     * @var type 
     */
    public $version = '3.2.0';

    /**
     * Respond.js version
     * @var string
     */
    public $respondJsVersion = '1.4.2';

    /**
     * jQuery version
     * @var string
     */
    public $jqueryVersion = '1.11.0';

    /**
     * Optional path for single assets:
     * @var array   array(
     *                  'basePath' => 'alias/path/to/assets/folder,
     *                  'baseUrl' => '/base/url/to/files
     *                  'css' => 'path/to/bootstrap.css',
     *                  'theme' => 'path/to/bootstrap-theme.css',
     *                  'js' => ('path/to/bootstrap.js', 'path/to/respond.js')
     *              );
     */
    public $assets = null;

    /**
     * Disable zooming for mobile devices
     * @var boolean
     */
    public $disableZoom = false;

    /**
     * Create the package from the assets array
     * @param array $assets
     * @return array
     */
    private function makePackage($assets)
    {
        foreach(array('css', 'theme', 'js') as $asset)
        {
            if(!isset($this->assets[$asset]))
            {
                $this->assets[$asset] = $assets[$asset];
            }
        }

        if($this->useCDN)
        {
            $this->assets['basePath'] = NULL;
            $this->assets['baseUrl'] = $assets['baseUrl'];
        }
        else
        {
            $this->assets['basePath'] = 'application.components.bootstrap.assets';
            $this->assets['baseUrl'] = null;
        }

        return array(
            'basePath' => $this->assets['basePath'],
            'baseUrl' => $this->assets['baseUrl'] ? : null,
            'css' => array(
                $this->assets['css'],
                $this->assets['theme'],
            ),
            'js' => $this->assets['js']
        );
    }

    /**
     * Inizialization of the component: it publish and register automatically the css/js assets for Bootstrap.
     */
    public function init()
    {
        $minified = YII_DEBUG === false ? '.min' : '';

        if($this->assets === null)
        {
            if($this->useCDN)
            {
                $assets = array(
                    'baseUrl' => '/',
                    'css' => "/maxcdn.bootstrapcdn.com/bootstrap/{$this->version}/css/bootstrap{$minified}.css",
                    'theme' => "/maxcdn.bootstrapcdn.com/bootstrap/{$this->version}/css/bootstrap-theme{$minified}.css",
                    'js' => array(
                        "/ajax.googleapis.com/ajax/libs/jquery/{$this->jqueryVersion}/jquery.min.js",
                        "/maxcdn.bootstrapcdn.com/bootstrap/{$this->version}/js/bootstrap{$minified}.js")
                );
            }
            else
            {
                $assets = array(
                    'css' => "css/bootstrap{$minified}.css",
                    'theme' => "css/bootstrap-theme{$minified}.css",
                    'js' => array(
                        "js/jquery.min.js",
                        "js/bootstrap{$minified}.js"),
                );
            }
        }
        else
        {
            $assets = $this->assets;
        }
        $assets = $this->makePackage($assets);

        if(preg_match('/MSIE [1-8]\./', Yii::app()->request->userAgent) === 1)
        {
            //TODO: CDN/X-Domain Setup for respond.js
            $respondJS = $this->useCDN === true ? "https://oss.maxcdn.com/libs/respond.js/{$this->respondJsVersion}/respond.min.js" : 'js/respond.min.js';
            $assets['js'][] = $respondJS;
            //TODO: disabled attribute doesnt work on IE<8 and the plugin doesnt work when you set it true;
        }

        Yii::app()->clientScript->addPackage('bootstrap', $assets)->registerPackage('bootstrap');

        /* Force the latest rendering mode in IE */
        Yii::app()->clientScript->registerMetaTag('IE=edge', null, 'X-UA-Compatible');

        /* Media queries fix for IE10 on Windows 8 and Windows Phone 8 pre-GDR3 */
        Yii::app()->clientScript->registerCss('ie-viewport-css', '@-webkit-viewport{width: device-width;}@-moz-viewport{width:device-width;}@-ms-viewport{width:device-width;}@-o-viewport{width:device-width;}@viewport{width:device-width;}');
        Yii::app()->clientScript->registerScript('ie-viewport-js', "if(navigator.userAgent.match(/IEMobile\/10\.0/)){var msViewportStyle = document.createElement('style');msViewportStyle.appendChild(document.createTextNode('@-ms-viewport{width:auto!important}'));document.querySelector('head').appendChild(msViewportStyle);}", CClientScript::POS_HEAD);

        /* Android stock browser fixes */
        Yii::app()->clientScript->registerScript('android-stock-js', 'var nua = navigator.userAgent;var isAndroid = (nua.indexOf("Mozilla/5.0") > -1 && nua.indexOf("Android ") > -1 && nua.indexOf("AppleWebKit") > -1 && nua.indexOf("Chrome") === -1);if(isAndroid){$("select.form-control").removeClass("form-control").css("width", "100%");}', CClientScript::POS_END);

        /* Fix rendering and touch zoom on mobile devices */
        Yii::app()->clientScript->registerMetaTag('width=device-width, initial-scale=1' . ($this->disableZoom === true ? ' , maximum-scale=1, user-scalable=no' : ''), null, 'viewport');

        /* Fix for Firefox when a fieldset is ued inside a responsive table */
        Yii::app()->clientScript->registerCss('firefox-fiedlset-responsive-table', '@-moz-document url-prefix(){fieldset { display: table-cell; }}');
    }

}
