/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import 'grapesjs/dist/css/grapes.min.css';
import 'grapesjs-preset-webpage/dist/grapesjs-preset-webpage.min.css';

// start the Stimulus application
import './bootstrap';

import ReactDom from 'react-dom';
import React from 'react';
import grapesjs from 'grapesjs';
import $ from 'jquery';
import pluginTooltip from 'grapesjs-tooltip';
import grapesjsCustomCode from 'grapesjs-custom-code';
import grapesjsLorySlider from 'grapesjs-lory-slider';
import grapesjsTabs from 'grapesjs-tabs';
import grapesjsTouch from 'grapesjs-touch';
import grapesjsParserPostcss from 'grapesjs-parser-postcss';
import grapesjsImageEditor from 'grapesjs-tui-image-editor';
import grapesjsTyped from 'grapesjs-typed';
import grapesjsStyleBg from 'grapesjs-style-bg';
import grapesjsPresetWebpage from 'grapesjs-preset-webpage';
import grapesjsPluginIframe from 'grapesjs-plugin-iframe';
import TestButton from "./modules/test-button/test-button";
import { Calculator } from "./modules/calculator-form/components/Calculator";
import calculatorFormAnyPurposeComponent from './modules/calculator-form/calculator-form-component';
import testButtonComponent from './modules/test-button/test-button-component';

const editor  = grapesjs.init({
    avoidInlineStyle: 1,
    height: '100%',
    container : '#gjs',
    fromElement: 1,
    showOffsets: 1,
    storeOnChange: true,
    storeAfterUpload: true,
    assetManager: {
        embedAsBase64: 1,
    },
    selectorManager: { componentFirst: true },
    styleManager: { clearProperties: 1 },
    storageManager: {
        id: 'gjs-', // Prefix identifier that will be used on parameters
        type: 'remote', //type: 'local', type: 'remote',Type of the storage
        autosave: false, // Store data automatically
        autoload: false, // Autoload stored data on init
        contentTypeJson: false,
        storeComponents: true,
        storeStyles: true,
        storeHtml: true,
        storeCss: true
    },
    plugins: [
        grapesjsLorySlider,
        grapesjsTabs,
        grapesjsCustomCode,
        grapesjsTouch,
        grapesjsParserPostcss,
        pluginTooltip,
        grapesjsImageEditor,
        grapesjsTyped,
        grapesjsStyleBg,
        grapesjsPresetWebpage,
        grapesjsPluginIframe
    ],
    pluginsOpts: {
        grapesjsLorySlider: {
            sliderBlock: {
                category: 'Extra'
            }
        },
        grapesjsTabs: {
            tabsBlock: {
                category: 'Extra'
            }
        },
        grapesjsTyped: {
            block: {
                category: 'Extra',
                content: {
                    type: 'typed',
                    'type-speed': 40,
                    strings: [
                        'Text row one',
                        'Text row two',
                        'Text row three',
                    ],
                }
            }
        },
        grapesjsPresetWebpage: {
            modalImportTitle: 'Import Template',
            modalImportLabel: '<div style="margin-bottom: 10px; font-size: 13px;">Paste here your HTML/CSS and click Import</div>',
            modalImportContent: function(editor) {
                return editor.getHtml() + '<style>'+editor.getCss()+'</style>'
            },
            filestackOpts: null,
            aviaryOpts: false,
            blocksBasicOpts: { flexGrid: 1 },
            customStyleManager: [{
                name: 'General',
                buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom'],
                properties:[{
                    name: 'Alignment',
                    property: 'float',
                    type: 'radio',
                    defaults: 'none',
                    list: [
                        { value: 'none', className: 'fa fa-times'},
                        { value: 'left', className: 'fa fa-align-left'},
                        { value: 'right', className: 'fa fa-align-right'}
                    ],
                },
                    { property: 'position', type: 'select'}
                ],
            },{
                name: 'Dimension',
                open: false,
                buildProps: ['width', 'flex-width', 'height', 'max-width', 'min-height', 'margin', 'padding'],
                properties: [{
                    id: 'flex-width',
                    type: 'integer',
                    name: 'Width',
                    units: ['px', '%'],
                    property: 'flex-basis',
                    toRequire: 1,
                },{
                    property: 'margin',
                    properties:[
                        { name: 'Top', property: 'margin-top'},
                        { name: 'Right', property: 'margin-right'},
                        { name: 'Bottom', property: 'margin-bottom'},
                        { name: 'Left', property: 'margin-left'}
                    ],
                },{
                    property  : 'padding',
                    properties:[
                        { name: 'Top', property: 'padding-top'},
                        { name: 'Right', property: 'padding-right'},
                        { name: 'Bottom', property: 'padding-bottom'},
                        { name: 'Left', property: 'padding-left'}
                    ],
                }],
            },{
                name: 'Typography',
                open: false,
                buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height', 'text-align', 'text-decoration', 'text-shadow'],
                properties:[
                    { name: 'Font', property: 'font-family'},
                    { name: 'Weight', property: 'font-weight'},
                    { name:  'Font color', property: 'color'},
                    {
                        property: 'text-align',
                        type: 'radio',
                        defaults: 'left',
                        list: [
                            { value : 'left',  name : 'Left',    className: 'fa fa-align-left'},
                            { value : 'center',  name : 'Center',  className: 'fa fa-align-center' },
                            { value : 'right',   name : 'Right',   className: 'fa fa-align-right'},
                            { value : 'justify', name : 'Justify',   className: 'fa fa-align-justify'}
                        ],
                    },{
                        property: 'text-decoration',
                        type: 'radio',
                        defaults: 'none',
                        list: [
                            { value: 'none', name: 'None', className: 'fa fa-times'},
                            { value: 'underline', name: 'underline', className: 'fa fa-underline' },
                            { value: 'line-through', name: 'Line-through', className: 'fa fa-strikethrough'}
                        ],
                    },{
                        property: 'text-shadow',
                        properties: [
                            { name: 'X position', property: 'text-shadow-h'},
                            { name: 'Y position', property: 'text-shadow-v'},
                            { name: 'Blur', property: 'text-shadow-blur'},
                            { name: 'Color', property: 'text-shadow-color'}
                        ],
                    }],
            },{
                name: 'Decorations',
                open: false,
                buildProps: ['opacity', 'border-radius', 'border', 'box-shadow', 'background-bg'],
                properties: [{
                    type: 'slider',
                    property: 'opacity',
                    defaults: 1,
                    step: 0.01,
                    max: 1,
                    min:0,
                },{
                    property: 'border-radius',
                    properties  : [
                        { name: 'Top', property: 'border-top-left-radius'},
                        { name: 'Right', property: 'border-top-right-radius'},
                        { name: 'Bottom', property: 'border-bottom-left-radius'},
                        { name: 'Left', property: 'border-bottom-right-radius'}
                    ],
                },{
                    property: 'box-shadow',
                    properties: [
                        { name: 'X position', property: 'box-shadow-h'},
                        { name: 'Y position', property: 'box-shadow-v'},
                        { name: 'Blur', property: 'box-shadow-blur'},
                        { name: 'Spread', property: 'box-shadow-spread'},
                        { name: 'Color', property: 'box-shadow-color'},
                        { name: 'Shadow type', property: 'box-shadow-type'}
                    ],
                },{
                    id: 'background-bg',
                    property: 'background',
                    type: 'bg',
                },],
            },{
                name: 'Extra',
                open: false,
                buildProps: ['transition', 'perspective', 'transform'],
                properties: [{
                    property: 'transition',
                    properties:[
                        { name: 'Property', property: 'transition-property'},
                        { name: 'Duration', property: 'transition-duration'},
                        { name: 'Easing', property: 'transition-timing-function'}
                    ],
                },{
                    property: 'transform',
                    properties:[
                        { name: 'Rotate X', property: 'transform-rotate-x'},
                        { name: 'Rotate Y', property: 'transform-rotate-y'},
                        { name: 'Rotate Z', property: 'transform-rotate-z'},
                        { name: 'Scale X', property: 'transform-scale-x'},
                        { name: 'Scale Y', property: 'transform-scale-y'},
                        { name: 'Scale Z', property: 'transform-scale-z'}
                    ],
                }]
            },{
                name: 'Flex',
                open: false,
                properties: [{
                    name: 'Flex Container',
                    property: 'display',
                    type: 'select',
                    defaults: 'block',
                    list: [
                        { value: 'block', name: 'Disable'},
                        { value: 'flex', name: 'Enable'}
                    ],
                },{
                    name: 'Flex Parent',
                    property: 'label-parent-flex',
                    type: 'integer',
                },{
                    name      : 'Direction',
                    property  : 'flex-direction',
                    type    : 'radio',
                    defaults  : 'row',
                    list    : [{
                        value   : 'row',
                        name    : 'Row',
                        className : 'icons-flex icon-dir-row',
                        title   : 'Row',
                    },{
                        value   : 'row-reverse',
                        name    : 'Row reverse',
                        className : 'icons-flex icon-dir-row-rev',
                        title   : 'Row reverse',
                    },{
                        value   : 'column',
                        name    : 'Column',
                        title   : 'Column',
                        className : 'icons-flex icon-dir-col',
                    },{
                        value   : 'column-reverse',
                        name    : 'Column reverse',
                        title   : 'Column reverse',
                        className : 'icons-flex icon-dir-col-rev',
                    }],
                },{
                    name      : 'Justify',
                    property  : 'justify-content',
                    type    : 'radio',
                    defaults  : 'flex-start',
                    list    : [{
                        value   : 'flex-start',
                        className : 'icons-flex icon-just-start',
                        title   : 'Start',
                    },{
                        value   : 'flex-end',
                        title    : 'End',
                        className : 'icons-flex icon-just-end',
                    },{
                        value   : 'space-between',
                        title    : 'Space between',
                        className : 'icons-flex icon-just-sp-bet',
                    },{
                        value   : 'space-around',
                        title    : 'Space around',
                        className : 'icons-flex icon-just-sp-ar',
                    },{
                        value   : 'center',
                        title    : 'Center',
                        className : 'icons-flex icon-just-sp-cent',
                    }],
                },{
                    name      : 'Align',
                    property  : 'align-items',
                    type    : 'radio',
                    defaults  : 'center',
                    list    : [{
                        value   : 'flex-start',
                        title    : 'Start',
                        className : 'icons-flex icon-al-start',
                    },{
                        value   : 'flex-end',
                        title    : 'End',
                        className : 'icons-flex icon-al-end',
                    },{
                        value   : 'stretch',
                        title    : 'Stretch',
                        className : 'icons-flex icon-al-str',
                    },{
                        value   : 'center',
                        title    : 'Center',
                        className : 'icons-flex icon-al-center',
                    }],
                },{
                    name: 'Flex Children',
                    property: 'label-parent-flex',
                    type: 'integer',
                },{
                    name:     'Order',
                    property:   'order',
                    type:     'integer',
                    defaults :  0,
                    min: 0
                },{
                    name    : 'Flex',
                    property  : 'flex',
                    type    : 'composite',
                    properties  : [{
                        name:     'Grow',
                        property:   'flex-grow',
                        type:     'integer',
                        defaults :  0,
                        min: 0
                    },{
                        name:     'Shrink',
                        property:   'flex-shrink',
                        type:     'integer',
                        defaults :  0,
                        min: 0
                    },{
                        name:     'Basis',
                        property:   'flex-basis',
                        type:     'integer',
                        units:    ['px','%',''],
                        unit: '',
                        defaults :  'auto',
                    }],
                },{
                    name      : 'Align',
                    property  : 'align-self',
                    type      : 'radio',
                    defaults  : 'auto',
                    list    : [{
                        value   : 'auto',
                        name    : 'Auto',
                    },{
                        value   : 'flex-start',
                        title    : 'Start',
                        className : 'icons-flex icon-al-start',
                    },{
                        value   : 'flex-end',
                        title    : 'End',
                        className : 'icons-flex icon-al-end',
                    },{
                        value   : 'stretch',
                        title    : 'Stretch',
                        className : 'icons-flex icon-al-str',
                    },{
                        value   : 'center',
                        title    : 'Center',
                        className : 'icons-flex icon-al-center',
                    }],
                }]
            }
            ],
        },
    },
});

editor.I18n.addMessages({
    en: {
        styleManager: {
            properties: {
                'background-repeat': 'Repeat',
                'background-position': 'Position',
                'background-attachment': 'Attachment',
                'background-size': 'Size',
            }
        },
    }
});

// load components
testButtonComponent(editor);
calculatorFormAnyPurposeComponent(editor);

var pn = editor.Panels;
var modal = editor.Modal;
var cmdm = editor.Commands;
cmdm.add('canvas-clear', function() {
    if(confirm('Areeee you sure to clean the canvas?')) {
        editor.DomComponents.clear();
        setTimeout(function(){ localStorage.clear()}, 0)
    }
});
cmdm.add('set-device-desktop', {
    run: function(ed) { ed.setDevice('Desktop') },
    stop: function() {},
});
cmdm.add('set-device-tablet', {
    run: function(ed) { ed.setDevice('Tablet') },
    stop: function() {},
});
cmdm.add('set-device-mobile', {
    run: function(ed) { ed.setDevice('Mobile portrait') },
    stop: function() {},
});

// Store DB
cmdm.add('save-database', {
    run: function (em, sender) {
        sender.set('active', true);
        if (!isEditDelayed) {
            updateProductDesign();
        } else {
            showModalPublicationTimePicker();
        }
    }
});

cmdm.add('view-page', {
    run: function (em, sender) {
        sender.set('active', true);
        viewContent();
    }
});

// Add info command
cmdm.add('open-info', function() {
    let mdlClass = 'gjs-mdl-dialog-sm';
    let infoContainer = document.getElementById('info-panel');
    let mdlDialog = document.querySelector('.gjs-mdl-dialog');
    mdlDialog.className += ' ' + mdlClass;
    infoContainer.style.display = 'block';
    modal.setTitle('About this demo');
    modal.setContent(infoContainer);
    modal.open();
    modal.getModel().once('change:open', function() {
        mdlDialog.className = mdlDialog.className.replace(mdlClass, '');
    })
});

pn.addButton('options', {
    id: 'open-info',
    className: 'fa fa-question-circle',
    command: function() { editor.runCommand('open-info') },
    attributes: {
        'title': 'About',
        'data-tooltip-pos': 'bottom',
    },
});

pn.addButton('options', [{
    id: 'save-database',
    className: 'fa fa-floppy-o',
    command: 'save-database',
    attributes: {
        title: 'Сохранить страницу',
        'data-tooltip-pos': 'bottom'
    }
}]);

// Add and beautify tooltips
[['sw-visibility', 'Show Borders'], ['preview', 'Preview'], ['fullscreen', 'Fullscreen'],
    ['export-template', 'Export'], ['undo', 'Undo'], ['redo', 'Redo'],
    ['gjs-open-import-webpage', 'Import'], ['canvas-clear', 'Clear canvas']]
    .forEach(function(item) {
        pn.getButton('options', item[0]).set('attributes', {title: item[1], 'data-tooltip-pos': 'bottom'});
    });
[['open-sm', 'Style Manager'], ['open-layers', 'Layers'], ['open-blocks', 'Blocks']]
    .forEach(function(item) {
        pn.getButton('views', item[0]).set('attributes', {title: item[1], 'data-tooltip-pos': 'bottom'});
    });
let titles = document.querySelectorAll('*[title]');

for (let i = 0; i < titles.length; i++) {
    let el = titles[i];
    let title = el.getAttribute('title');

    title = title ? title.trim(): '';

    if (title) {
        el.setAttribute('data-tooltip', title);
        el.setAttribute('title', '');
    }
}

// Show borders by default
pn.getButton('options', 'sw-visibility').set('active', 1);


// Store and load events
editor.on('storage:load', function(e) { console.log('Loaded ', e) });
editor.on('storage:store', function(e) { console.log('Stored ', e) });

// Do stuff on load
editor.on('load', function() {
    var $ = grapesjs.$;

    // Load and show settings and style manager
    let openTmBtn = pn.getButton('views', 'open-tm');
    openTmBtn && openTmBtn.set('active', 1);
    let openSm = pn.getButton('views', 'open-sm');
    openSm && openSm.set('active', 1);

    // Add Settings Sector
    let traitsSector = $('<div class="gjs-sm-sector no-select">'+
        '<div class="gjs-sm-title"><span class="icon-settings fa fa-cog"></span> Settings</div>' +
        '<div class="gjs-sm-properties" style="display: none;"></div></div>');
    let traitsProps = traitsSector.find('.gjs-sm-properties');
    traitsProps.append($('.gjs-trt-traits'));
    $('.gjs-sm-sectors').before(traitsSector);
    traitsSector.find('.gjs-sm-title').on('click', function(){
        let traitStyle = traitsProps.get(0).style;
        if (traitStyle.display === 'none') {
            traitStyle.display = 'block';
        }
    });

    let openBlocksBtn = editor.Panels.getButton('views', 'open-blocks');
    openBlocksBtn && openBlocksBtn.set('active', 1);
    $('#gjs').append($('.ad-cont'));
});

const publicationTimePicker = $('.publicationTime');

const sendContent = (url) => {
    let html = editor.getHtml();
    let style = editor.getCss();
    let publicationTime = publicationTimePicker.val();
    $.ajax({
        url: url + id,
        type: 'POST',
        data: {html: html, style: style, publicationTime: publicationTime}
    }).done(function (response) {
        showResponse(response.data);
    }).fail(function(response) {
        showResponse(response.responseJSON);
    });
}

const showResponse = (data) => {
    showModalWindow();
    $('.js-modal-response').addClass('open');
    $('.message-response').text(data.message);
    $('.validate_message_error').detach();
    if (data.errors) {
        let errors = data.errors;
        for (let key in errors) {
            errors[key].map(function(error) {
                $('.message-errors').append('<p class="validate_message_error">' + error + '</p>');
            });
        }
    }
}

const updateProductDesign = () => {
    sendContent('/updateProductDesign/');
}

const saveDelayDesign = () => {
    sendContent('/saveDelayDesign/');
}

const showModalWindow = () => {
    $('body').addClass('modal-open');
    $('.overlay').addClass('visible');
}

const hideModalWindow = () => {
    $('body').removeClass('modal-open');
    $('.overlay').removeClass('visible');
    $('.js-modal-response').removeClass('open');
    $('.js-datetime-picker-form').removeClass('open');
}

const showModalPublicationTimePicker = () => {
    showModalWindow();
    $('.js-datetime-picker-form').addClass('open');
}

const deleteAllError = () => {
    $('.input_error').detach();
    $('input').removeClass('has-error')
}

$(document).ready(function () {
    $('.overlay').click(function () {
        hideModalWindow();
    });

    $('.js-modal-close').click(function () {
        hideModalWindow();
    });

    $('.js-save-content-page').click(function () {
        deleteAllError();
        if (publicationTimePicker.val()) {
            hideModalWindow();
            saveDelayDesign();
        } else {
            publicationTimePicker.after('<p class="input_error">Не указано дата и время опубликации</p>');
            publicationTimePicker.addClass('has-error');
        }
    });
});

if (frames[0].document) {
    for (let style of styles) {
        const cssLinkIframe = window.frames[0].document.createElement('link');
        cssLinkIframe.href = style;
        cssLinkIframe.rel = 'stylesheet';
        cssLinkIframe.type = 'text/css';
        window.frames[0].document.head.appendChild(cssLinkIframe);
    }
}

frames[0].document.querySelectorAll('.test_button_container').forEach(el => {
    ReactDom.render(<TestButton />, el);
});

frames[0].document.querySelectorAll('.calculator_form_container').forEach(el => {
    const creditTitle = el.getAttribute('creditTitle');
    ReactDom.render(<Calculator creditTitle={creditTitle}/>, el);
});

