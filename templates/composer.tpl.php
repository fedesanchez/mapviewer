<!DOCTYPE html>
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
        <script type="text/javascript" src="src/override-ext-ajax.js"></script>
        <script type="text/javascript" src="src/lib.js"></script>
        <script type="text/javascript" src="<?php echo $map;?>"></script>
        <script>
            Ext.BLANK_IMAGE_URL = "theme/app/img/blank.gif";
            OpenLayers.ImgPath = "externals/openlayers/img/";
            GeoExt.Lang.set("es");
            OpenLayers.ProxyHost="/pruebas/proxy/?url=";
                
            if(AppResponse.status==200){
                var json=AppResponse.request[0];
                json="{"+json+"}";
                var map=Ext.util.JSON.decode(json);
                var app = new gxp.Viewer(map);    
            }
            
            function test(){
                var map=Ext.util.JSON.encode(app.map);
                alert(map);
            }

            function save(callback, scope) {
                var configStr = Ext.util.JSON.encode(app.map);
                var method, url;
                if (this.id) {
                    method = "PUT";
                    url = "../maps/" + this.id;
                } else {
                    method = "POST";
                    url = "maps.php";
                }
                var requestConfig = {
                    method: method,
                    url: url,
                    data: configStr
                };
                if (this.fireEvent("beforesave", requestConfig, callback) !== false) {
                    OpenLayers.Request.issue(Ext.apply(requestConfig, {
                        callback: function(request) {
                            this.handleSave(request);
                            if (callback) {
                                callback.call(scope || this);
                            }
                        },
                        scope: this
                    }));
                }
            }
        
    /** private: method[handleSave]
     *  :arg: ``XMLHttpRequest``
     */
    function handleSave(request) {
        if (request.status == 200) {
            var config = Ext.util.JSON.decode(request.responseText);
            var mapId = config.id;
            if (mapId) {
                this.id = mapId;
                var hash = "#maps/" + mapId;
                if (this.fireEvent("beforehashchange", hash) !== false) {
                    window.location.hash = hash;
                }
                this.fireEvent("save", this.id);
            }
        } else {
            if (window.console) {
                console.warn(this.saveErrorText + request.responseText);
            }
        }
    }


        </script>
    </head>
    <body></body>
</html>
