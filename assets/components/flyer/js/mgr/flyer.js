Ext.ns('flyer');


flyer.ckeditor = function (editorConfig) {
	Ext.apply(this.cfg, editorConfig, {});
	flyer.ckeditor.superclass.constructor.call(this);
};


Ext.extend(flyer.ckeditor, Ext.Component, {
	cfg: {
		selector: '#ta',
		element: null,
		editorCompact: {
			'ta': false,
			'modx-richtext': true,
		},
		skin: 'moono'
	},

	initComponent: function () {
		flyer.ckeditor.superclass.initComponent.call(this);
		Ext.onReady(this.render, this);
	},

	render: function () {
		Ext.apply(this.cfg, flyer.config, flyer.editorConfig, {});
		if (this.cfg.element) {
			this.initialize(this.cfg.element, this.cfg);
		} else {
			Ext.each(Ext.query(this.cfg.selector), function (element) {
				this.cfg.element = element;
				this.initialize(element, this.cfg);
			}, this);
		}
	},

	setConfig: function (config) {

		if (!config['filebrowserBrowseUrl']) {
			config['filebrowserBrowseUrl'] = flyer.tools.getFileBrowserUrl();
		}
		if (!config['filebrowserUploadUrl']) {
			config['filebrowserUploadUrl'] = flyer.tools.getPluginActionUrl('filebrowser', 'upload');
		}

		config['componentName'] = flyer.tools.getComponentNameBySelector(config['selector']);
		config['contentSeparator'] = flyer.tools.getСontentSeparator(config['enterMode']);

		/* compact mode */
		if (flyer.tools.keyExists(config['componentName'], config['editorCompact'])) {
			config['editorCompact'] = config['editorCompact'][config['componentName']];
		}
		else {
			config['editorCompact'] = true;
		}

		return config;
	},

	initialize: function (el, config) {
		var uid = el.id;

		var editor = CKEDITOR.instances[uid] || null;
		if (editor) {
			return false;
		}

		config = this.setConfig(config);

		if (!config['height']) {
			config['height'] = parseInt(el.offsetHeight) || 200;
		}

		if (config['addExternalPlugins']) {
			for (var name in config['addExternalPlugins']) {
				var script = config['addExternalPlugins'][name];
				if (script) {
					CKEDITOR.plugins.addExternal(name, config['assetsUrl'] + script, '');
				}
			}
		}

		if (config['addExternalSkin']) {
			for (var name in config['addExternalSkin']) {
				var skin = config['addExternalSkin'][name];
				if (skin && name == config.skin) {
					config.skin = skin + ',' + config['assetsUrl'] + skin;
				}
			}
		}

		/* compact mode */
		if (config['editorCompact']) {
			editor = CKEDITOR.inline(uid, config);
		}
		else {
			editor = CKEDITOR.replace(uid, config);
		}

		if (!editor) {
			return false;
		}

		/* add save */
		editor.setKeystroke(CKEDITOR.CTRL + 83, '_save');
		editor.addCommand('_save', {
			exec: function (editor) {
				var updateButton = flyer.tools.getUpdateButton();
				if (updateButton) {
					MODx.activePage.ab.handleClick(updateButton);
				}
			}
		});

		/* add droppable */
		if (config['droppable']) {
			editor.on('uiReady', function () {
				this.registerDrop(editor, config);
			}, this);
		}

		/* fix change value */
		editor.on('change', function (ev) {
			if (ev.editor && ev.editor.config && ev.editor.config.element) {
				ev.editor.config.element.value = editor.getData();
			}
		});

		/*  */
		CKEDITOR.on("instanceReady", function (ev) {

			/* add flyer-load class */
			ev.editor.element.$.classList.add("flyer-load");
		});

	},

	registerDrop: function (editor, config) {
		if (!editor.container || !editor.container.$) {
			return false;
		}

		var ddTarget = new Ext.Element(editor.container.$, true),
			ddTargetEl = ddTarget.dom;

		var separator = config['contentSeparator'] || "\n";
		var insert = {
			text: function (text) {
				var regex = /<br\s*[\/]?>/gi;
				editor.insertText(text.replace(regex, separator));
				editor.focus();
			},
			link: function (id, text) {
				if (text) {
					var element = '<a href="[[~' + id + ']]" title="' + text + '">' + text + '</a>';
					editor.insertHtml(element);
					editor.focus();
				}
			},
			file: function (path, type) {
				if (type) {
					var element = '<' + type + ' src="/' + path + '" controls="">';
					editor.insertHtml(element);
					editor.focus();
				}
			},
			devtags: function (text) {
				text = "<pre><devtags>\n" + text + "\n</devtags></pre>";
				editor.insertHtml(text);
				editor.focus();
			},
			block: function (text) {
				editor.insertHtml(text + separator);
				editor.focus();
			},
		};

		var dropTarget = new Ext.dd.DropTarget(ddTargetEl, {
			ddGroup: 'modx-treedrop-dd',

			_notifyEnter: function (ddSource, e, data) {
				fakeDiv = Ext.DomHelper.insertAfter(ddTarget, {
					tag: 'div',
					style: 'position: absolute;top: 0;left: 0;right: 0;bottom: 0;'
				});
				ddTarget.frame();
				editor.focus();
			},

			notifyOut: function (ddSource, e, data) {
				fakeDiv && fakeDiv.remove();
				ddTarget.on('mouseover', onMouseOver);
			},

			notifyDrop: function (ddSource, e, data) {
				fakeDiv && fakeDiv.remove();
				ddTarget.on('mouseover', onMouseOver);

				var v = '',
					win = false,
					block = false;

				if (editor.mode != 'wysiwyg') {
					return false;
				}

				console.log(data);

				switch (data.node.attributes.type) {
					case 'modResource':
						insert.link(data.node.attributes.pk, data.node.text.replace(/\s*<.*>.*<.*>/, ''));
						break;
					case 'snippet':
						win = true;
						break;
					case 'chunk':
						win = true;
						break;
					case 'tv':
						win = true;
						break;
					case 'file':
						var types = {
							'jpg': 'image',
							'jpeg': 'image',
							'png': 'image',
							'gif': 'image',
							'svg': 'image',
							'ogg': 'audio',
							'mp3': 'audio',
							'ogv': 'video',
							'webm': 'video',
							'mp4': 'video'
						};
						var ext = data.node.attributes.text.substring(data.node.attributes.text.lastIndexOf('.') + 1);

						if (types[ext]) {
							insert.file(data.node.attributes.url, types[ext]);
						} else {
							insert.text(data.node.attributes.url);
						}

						break;
					case 'block':
						block = true;
						break;

					default:
						var dh = Ext.getCmp(data.node.attributes.type + '-drop-handler');
						if (dh) {
							return dh.handle(data, {
								ddTargetEl: ddTargetEl,
								cfg: cfg,
								iframe: true,
								iframeEl: ddTargetEl,
								onInsert: insert.text
							});
						}
						return false;
						break;
				}

				if (win) {
					MODx.loadInsertElement({
						pk: data.node.attributes.pk,
						classKey: data.node.attributes.classKey,
						name: data.node.attributes.name,
						output: v,
						ddTargetEl: ddTargetEl,
						cfg: {onInsert: insert.devtags},
						iframe: true,
						onInsert: insert.devtags
					});
				} else if (block && MODx.loadInsertBlock) {
					MODx.loadInsertBlock({
						pk: data.node.attributes.pk,
						classKey: data.node.attributes.classKey,
						name: data.node.attributes.name,
						output: v,
						ddTargetEl: ddTargetEl,
						cfg: {onInsert: insert.block},
						iframe: true,
						onInsert: insert.block
					});
				}

				return true;
			}
		});

		dropTarget.addToGroup('modx-treedrop-elements-dd');
		dropTarget.addToGroup('modx-treedrop-sources-dd');

		var onMouseOver = function (e) {
			if (Ext.dd.DragDropMgr.dragCurrent) {
				dropTarget._notifyEnter();
				ddTarget.un('mouseover', onMouseOver);
			}
		};
		ddTarget.on('mouseover', onMouseOver);

		this.on('destroy', function () {
			dropTarget.destroy();
		});
	}

});


flyer.loadEditorForFields = function (fields) {
	if (flyer.config == undefined) {
		return false;
	}

	flyer.config['additional_editor_fields'] = fields || flyer.config['additional_editor_fields'] || [];
	flyer.config['additional_editor_fields'].filter(function (field) {

		Ext.each(Ext.query('#' + field), function (element) {
			new flyer.ckeditor({
				selector: '#' + field,
				element: element,
				droppable: true
			});
		}, this);

		Ext.each(Ext.query('.' + field), function (element) {
			new flyer.ckeditor({
				selector: '.' + field,
				element: element,
				droppable: true
			});
		}, this);
	});

};


MODx.loadRTE = function (id) {
	if (flyer.config == undefined) {
		return false;
	}

	Ext.each(Ext.query('#' + id), function (element) {
		new flyer.ckeditor({
			selector: '#' + id,
			element: element,
			droppable: true
		});
	}, this);
};


MODx.unloadRTE = function (id) {
	var editor = CKEDITOR.instances[id];
	if (editor) {
		CKEDITOR.remove(editor);

		/* remove flyer-load class */
		editor.element.$.classList.remove("flyer-load");
		editor.destroy(true);
	}
};
