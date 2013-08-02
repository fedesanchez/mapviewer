- Table: app.maps

-- DROP TABLE app.maps;

CREATE TABLE app.maps
(
  id serial NOT NULL,
  portalconfig text,
  tools text DEFAULT '{ "tools": [{ptype: "gxp_layertree", outputConfig: { id: "tree", border: true, tbar: []}, outputTarget: "westpanel"}, {ptype: "gxp_addlayers", actionTarget: "tree.tbar" }, { ptype: "gxp_removelayer", actionTarget: ["tree.tbar", "tree.contextMenu"]}, {ptype: "gxp_zoomtoextent",  actionTarget: "map.tbar"}, { ptype: "gxp_zoom", actionTarget: "map.tbar" }, { ptype: "gxp_navigationhistory", actionTarget: "map.tbar" },{ptype:"gxp_savemap",actionTarget:"map.tbar"}]}'::text,
  sources text,
  map text,
  description text,
  CONSTRAINT maps_pkey PRIMARY KEY (id )
)
WITH (
  OIDS=FALSE
);
ALTER TABLE app.maps
  OWNER TO postgres;