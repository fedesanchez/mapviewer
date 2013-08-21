<html>
    <head>
        <title>Segunda version</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="./favicon.ico">
        <script src="http://maps.google.com/maps/api/js?v=3.6&amp;sensor=false"></script>        
        <!-- Ext resources -->
        <link rel="stylesheet" type="text/css" href="src/ext/resources/css/ext-all.css">
        <link rel="stylesheet" type="text/css" href="src/ext/resources/css/xtheme-gray.css">
        <script type="text/javascript" src="src/ext/adapter/ext/ext-base.js"></script>
        <script type="text/javascript" src="src/ext/ext-all.js"></script>

        <!-- OpenLayers resources -->
        <link rel="stylesheet" type="text/css" href="src/openlayers/theme/default/style.css">

        <!-- GeoExt resources -->
        <link rel="stylesheet" type="text/css" href="src/geoext/resources/css/popup.css">
        <link rel="stylesheet" type="text/css" href="src/geoext/resources/css/layerlegend.css">
        <link rel="stylesheet" type="text/css" href="src/geoext/resources/css/gxtheme-gray.css">

        <!-- gxp resources -->
        <link rel="stylesheet" type="text/css" href="src/gxp/theme/all.css">
        

        <!-- app resources -->
        <link rel="stylesheet" type="text/css" href="theme/app/style.css">
        
    </head>
    <body></body>
    <script type="text/javascript" src="src/override-ext-ajax.js"></script>
        <script type="text/javascript" src="src/lib.js"></script>
        <script type="text/javascript" src="src/tools.js"></script>
        <script type="text/javascript" src="src/savemap.js"></script>
        
        <script type="text/javascript">
          var app;    

          Ext.onReady(function() {
            Ext.BLANK_IMAGE_URL = "theme/app/img/blank.gif";
            OpenLayers.ImgPath = "externals/openlayers/img/";
            GeoExt.Lang.set("es");
            OpenLayers.ProxyHost="proxy/?url=";
            
            Ext.Ajax.request({
                    url: "<?php echo $map;?>",
                    success: function(response) {                        
                        var obj = Ext.util.JSON.decode(response.responseText);
                        var data=obj[0].data;
                        var config = Ext.util.JSON.decode(data[0]); 
                        config.tools=tools;              
                                                                                         
                        app = new gxp.Viewer(config);
                        app._id="<?php echo $id;?>";
                    },
                    failure: function(response) {
                        console.log('server-side failure with status code ' + response.status);
                    }
            });
        });        
 
        </script>
</html>
