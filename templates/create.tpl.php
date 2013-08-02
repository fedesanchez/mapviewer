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
        <script type="text/javascript" src="src/savemap.js"></script>
        
        <script>
            Ext.BLANK_IMAGE_URL = "theme/app/img/blank.gif";
            OpenLayers.ImgPath = "externals/openlayers/img/";
            GeoExt.Lang.set("es");
            OpenLayers.ProxyHost="proxy/?url=";
            var app;
            app = new gxp.Viewer({
                portalConfig: {
                    layout: "border",
                    region: "center",
                    items: [{
                        id: "centerpanel",
                        xtype: "panel",
                        layout: "fit",
                        region: "center",
                        border: false,
                        items: ["mymap"]
                    }, {
                        id: "westpanel",
                        xtype: "container",
                        layout: "fit",
                        region: "west",
                        width: 200
                    }],
                    bbar: {id: "mybbar"}
                },
                 tools: [{
                    ptype: "gxp_layertree",
                    outputConfig: {
                        id: "tree",
                        border: true,
                        tbar: [] 
                        },
                        outputTarget: "westpanel"
                    }, {
                        ptype: "gxp_addlayers",
                        actionTarget: "tree.tbar"
                    }, {
                        ptype: "gxp_removelayer",
                        actionTarget: ["tree.tbar", "tree.contextMenu"]
                    }, {
                        ptype: "gxp_zoomtoextent",
                        actionTarget: "map.tbar"
                    }, {
                        ptype: "gxp_zoom",
                        actionTarget: "map.tbar"
                    }, {
                        ptype: "gxp_navigationhistory",
                        actionTarget: "map.tbar"
                    },{
                        ptype:"gxp_savemap",
                        actionTarget:"map.tbar"
                    }],
                sources: {
                     mapa: {
                        ptype: "gxp_wmscsource",
                        url: "http://localhost:8080/geoserver/wms",
                        version: "1.1.1"
                    },
                    osm: {
                        ptype: "gxp_osmsource"
                    }
                },
                map: {
                    id: "mymap", 
                    title: "Map",
                    projection: "EPSG:900913",
                    center: [-10764594.758211, 4523072.3184791],
                    zoom: 3,
                    layers: [{
                        source: "osm",
                        name: "mapnik",
                        group: "background"
                    }, 
                    {
                    source: "mapa",
                    name: "ogc.escuelas"
                    }],
                    items: [{
                        xtype: "gx_zoomslider",
                        vertical: true,
                        height: 100
                    }]
                }    


            });
 
        </script>
    </head>
    <body></body>
</html>
