BootstrapYii
============

BootstrapYii is a component for Yii which features:
* Automatically publish and register [Bootstrap](https://getbootstrap.com/) css/js assets
* Automatically add meta tag for proper rendering on mobile devices;
* Optionally load assets from CDN;
* Static class with helper method to avoid PHP and HTML mixup;
* Include [Respond.js](https://github.com/scottjehl/Respond) for IE 8.0 to enable responsive design;

Installation
------------
Create a `bootstrap` folder into the Yii's components folder (default: protected/components).

Configuration
---------------
For a simple and quick initialization, just add these lines to the settings of your web application (default: protected/config/main.php):
````php
	...
	'preload' => array('bootstrap'), // autoload and initialize the component
  	...
  	'components' => array(
	...
		'bootstrap' => array(
			'class' => 'application.components.bootstrap.Bootstrap' //alias path to the class file Bootstrap.php (required)
		),
	),
	...
````
Alternatively, you can add these optional parameters:
````php
	...
    'bootstrap' => array(
	    ...
        'basePath' => 'application.components.bootstrap'    // alias path for folder of the component
        'baseUrl' => '/url/to/assets'                       // base URL for the assets, if you use this "basePath" will be ignored
        'useCDN => false                                    // load assets from cdn
        'assets' =>array(                                   // list of assets path
	        'css'=> 'path/to/bootstrap.css',
	        'theme'=> 'path/to/bootstrap.css',
            'js' => array(
                'path/to/bootstrap.js',
                'path/to/respond.js',
            ),
        ),
        'disableZoom' => false                              // Disable zoom capabilities for mobile devices
    ),
	...
````

Examples
--------
Container, row, column.
````php
echo BHtml::openContainer();
    echo BHtml::openRow();
        echo BHtml::openColumn(array('sm'=>12, 'md'=>6 ,'lg'=>3));
            echo BHtml::heading(1,'This is a column');
        echo BHtml::closeColumn();
    echo Bhtml::closeRow();
echo BHtml::closeContainer();
````
````html
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-3">
            <h1 class="text-center">This is a column!</div>
        </div>
    </div>
</div>
````
Horizontal form with various controls.
````php
echo BHtml::openForm(array('horizontal'=>true));
    echo BHtml::openFormGroup();
        echo BHtml::label('Email', array('sizes'=>array('sm'=>'2')));
        echo BHtml::input('text', 'email', array('sizes'=>array('sm'=>10)));
    echo BHtml::closeFormGroup();
    echo BHtml::openFormGroup();
        echo BHtml::label('Password', array('sizes'=>array('sm'=>'2')));
        echo BHtml::input('password', 'password', array('sizes'=>array('sm'=>10)));
    echo BHtml::closeFormGroup();
    echo BHtml::openFormGroup();
        echo BHtml::checkbox('remember',null);
    echo BHtml::closeFormGroup();
    echo BHtml::openFormGroup();
        echo BHtml::openColumn(array('offset'=>array('sm'=>2), 'sizes'=>array('sm'=>10)));
            echo BHtml::submit('Submit', array('buttonState'=>'default'));
        echo BHtml::closeColumn();
    echo BHtml::closeFormGroup();
echo BHtml::closeForm();
````
````html
<form class="form-horizontal">
    <div class="form-group">
        <label class="control-label col-sm-2">Email</label>
        <div class="col-sm-10">
            <input type="text" name="email" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Password</label>
        <div class="col-sm-10">
            <input type="password" name="password" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="checkbox">
                <label>
                    <input value="1" type="checkbox" name="remember" />Remember me</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <button type="submit" class="btn btn-default">Sign in</button>
        </div>
    </div>
</form>
````
