/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayLikeToArray.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}

module.exports = _arrayLikeToArray;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/arrayWithHoles.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayWithHoles.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}

module.exports = _arrayWithHoles;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/assertThisInitialized.js ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }

  return self;
}

module.exports = _assertThisInitialized;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/classCallCheck.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/classCallCheck.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

module.exports = _classCallCheck;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/createClass.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/createClass.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  return Constructor;
}

module.exports = _createClass;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/defineProperty.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/defineProperty.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

module.exports = _defineProperty;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/extends.js":
/*!********************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/extends.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _extends() {
  module.exports = _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

module.exports = _extends;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/getPrototypeOf.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _getPrototypeOf(o) {
  module.exports = _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  return _getPrototypeOf(o);
}

module.exports = _getPrototypeOf;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/inherits.js":
/*!*********************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/inherits.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var setPrototypeOf = __webpack_require__(/*! ./setPrototypeOf */ "./node_modules/@babel/runtime/helpers/setPrototypeOf.js");

function _inherits(subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function");
  }

  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      writable: true,
      configurable: true
    }
  });
  if (superClass) setPrototypeOf(subClass, superClass);
}

module.exports = _inherits;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _iterableToArrayLimit(arr, i) {
  if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return;
  var _arr = [];
  var _n = true;
  var _d = false;
  var _e = undefined;

  try {
    for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
      _arr.push(_s.value);

      if (i && _arr.length === i) break;
    }
  } catch (err) {
    _d = true;
    _e = err;
  } finally {
    try {
      if (!_n && _i["return"] != null) _i["return"]();
    } finally {
      if (_d) throw _e;
    }
  }

  return _arr;
}

module.exports = _iterableToArrayLimit;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/nonIterableRest.js":
/*!****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/nonIterableRest.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

module.exports = _nonIterableRest;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/objectWithoutProperties.js":
/*!************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/objectWithoutProperties.js ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var objectWithoutPropertiesLoose = __webpack_require__(/*! ./objectWithoutPropertiesLoose */ "./node_modules/@babel/runtime/helpers/objectWithoutPropertiesLoose.js");

function _objectWithoutProperties(source, excluded) {
  if (source == null) return {};
  var target = objectWithoutPropertiesLoose(source, excluded);
  var key, i;

  if (Object.getOwnPropertySymbols) {
    var sourceSymbolKeys = Object.getOwnPropertySymbols(source);

    for (i = 0; i < sourceSymbolKeys.length; i++) {
      key = sourceSymbolKeys[i];
      if (excluded.indexOf(key) >= 0) continue;
      if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue;
      target[key] = source[key];
    }
  }

  return target;
}

module.exports = _objectWithoutProperties;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/objectWithoutPropertiesLoose.js":
/*!*****************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/objectWithoutPropertiesLoose.js ***!
  \*****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _objectWithoutPropertiesLoose(source, excluded) {
  if (source == null) return {};
  var target = {};
  var sourceKeys = Object.keys(source);
  var key, i;

  for (i = 0; i < sourceKeys.length; i++) {
    key = sourceKeys[i];
    if (excluded.indexOf(key) >= 0) continue;
    target[key] = source[key];
  }

  return target;
}

module.exports = _objectWithoutPropertiesLoose;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var _typeof = __webpack_require__(/*! ../helpers/typeof */ "./node_modules/@babel/runtime/helpers/typeof.js");

var assertThisInitialized = __webpack_require__(/*! ./assertThisInitialized */ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js");

function _possibleConstructorReturn(self, call) {
  if (call && (_typeof(call) === "object" || typeof call === "function")) {
    return call;
  }

  return assertThisInitialized(self);
}

module.exports = _possibleConstructorReturn;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/setPrototypeOf.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/setPrototypeOf.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _setPrototypeOf(o, p) {
  module.exports = _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  };

  return _setPrototypeOf(o, p);
}

module.exports = _setPrototypeOf;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/slicedToArray.js":
/*!**************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/slicedToArray.js ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var arrayWithHoles = __webpack_require__(/*! ./arrayWithHoles */ "./node_modules/@babel/runtime/helpers/arrayWithHoles.js");

var iterableToArrayLimit = __webpack_require__(/*! ./iterableToArrayLimit */ "./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js");

var unsupportedIterableToArray = __webpack_require__(/*! ./unsupportedIterableToArray */ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js");

var nonIterableRest = __webpack_require__(/*! ./nonIterableRest */ "./node_modules/@babel/runtime/helpers/nonIterableRest.js");

function _slicedToArray(arr, i) {
  return arrayWithHoles(arr) || iterableToArrayLimit(arr, i) || unsupportedIterableToArray(arr, i) || nonIterableRest();
}

module.exports = _slicedToArray;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/typeof.js":
/*!*******************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/typeof.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    module.exports = _typeof = function _typeof(obj) {
      return typeof obj;
    };
  } else {
    module.exports = _typeof = function _typeof(obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

module.exports = _typeof;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var arrayLikeToArray = __webpack_require__(/*! ./arrayLikeToArray */ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js");

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(n);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return arrayLikeToArray(o, minLen);
}

module.exports = _unsupportedIterableToArray;

/***/ }),

/***/ "./src/block.json":
/*!************************!*\
  !*** ./src/block.json ***!
  \************************/
/*! exports provided: name, category, attributes, transforms, supports, default */
/***/ (function(module) {

module.exports = {"name":"waveplayer/block","category":"common","attributes":{"className":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"class"},"url":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"data-url"},"caption":{"type":"string","source":"html","selector":"figcaption"},"ids":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"data-ids"},"size":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"data-size"},"skin":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"data-skin"},"palette":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"data-palette"},"style":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"data-style"},"shape":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"data-shape"},"wave_color":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"data-wave_color"},"wave_color_2":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"data-wave_color_2"},"progress_color":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"data-progress_color"},"progress_color_2":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"data-progress_color_2"},"cursor_color":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"data-cursor_color"},"cursor_color_2":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"data-cursor_color_2"},"wave_animation":{"type":"float","source":"attribute","selector":".waveplayer","attribute":"data-wave_animation"},"amp_freq_ratio":{"type":"float","source":"attribute","selector":".waveplayer","attribute":"data-amp_freq_ratio"},"autoplay":{"type":"boolean","source":"attribute","selector":".waveplayer","attribute":"data-autoplay"},"repeat":{"type":"boolean","source":"attribute","selector":".waveplayer","attribute":"data-repeat"},"shuffle":{"type":"boolean","source":"attribute","selector":".waveplayer","attribute":"data-shuffle"},"preload":{"type":"string","source":"attribute","selector":".waveplayer","attribute":"preload"}},"transforms":{"from":[{"type":"shortcode","tag":"waveplayer","attributes":{"ids":{"type":"string","shortcode":"attribute"}}}]},"supports":{"html":false}};

/***/ }),

/***/ "./src/edit.js":
/*!*********************!*\
  !*** ./src/edit.js ***!
  \*********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/defineProperty.js");
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "./node_modules/@babel/runtime/helpers/slicedToArray.js");
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "./node_modules/@babel/runtime/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/helpers/createClass */ "./node_modules/@babel/runtime/helpers/createClass.js");
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime/helpers/getPrototypeOf */ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @babel/runtime/helpers/assertThisInitialized */ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js");
/* harmony import */ var _babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @babel/runtime/helpers/inherits */ "./node_modules/@babel/runtime/helpers/inherits.js");
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _waveplayer_ssr__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./waveplayer-ssr */ "./src/waveplayer-ssr/index.js");
/* harmony import */ var _wordpress_blob__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @wordpress/blob */ "@wordpress/blob");
/* harmony import */ var _wordpress_blob__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blob__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @wordpress/editor */ "@wordpress/editor");
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(_wordpress_editor__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_13__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_14___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__);
/* harmony import */ var _icon__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! ./icon */ "./src/icon.js");










/**
 * WordPress dependencies
 */







/**
 * Internal dependencies
 */


var ALLOWED_MEDIA_TYPES = ['audio'];

var WavePlayer =
/*#__PURE__*/
function (_Component) {
  _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_7___default()(WavePlayer, _Component);

  function WavePlayer() {
    var _this;

    _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_2___default()(this, WavePlayer);

    _this = _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_4___default()(this, _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_5___default()(WavePlayer).apply(this, arguments));
    _this.state = {
      editing: !_this.props.attributes.url && !_this.props.attributes.ids
    };
    _this.toggleAttribute = _this.toggleAttribute.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_6___default()(_this));
    _this.onSelectURL = _this.onSelectURL.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_6___default()(_this));
    _this.onUploadError = _this.onUploadError.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_6___default()(_this));
    return _this;
  }

  _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_3___default()(WavePlayer, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      var _this2 = this;

      var _this$props = this.props,
          attributes = _this$props.attributes,
          mediaUpload = _this$props.mediaUpload,
          noticeOperations = _this$props.noticeOperations,
          setAttributes = _this$props.setAttributes;
      var ids = attributes.ids,
          _attributes$url = attributes.url,
          url = _attributes$url === void 0 ? '' : _attributes$url;

      if (!ids && Object(_wordpress_blob__WEBPACK_IMPORTED_MODULE_10__["isBlobURL"])(url)) {
        var file = Object(_wordpress_blob__WEBPACK_IMPORTED_MODULE_10__["getBlobByURL"])(url);

        if (file) {
          mediaUpload({
            filesList: [file],
            onFileChange: function onFileChange(_ref) {
              var _ref2 = _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1___default()(_ref, 1),
                  _ref2$ = _ref2[0],
                  mediaId = _ref2$.ids,
                  url = _ref2$.url;

              setAttributes({
                ids: mediaId,
                url: url
              });
            },
            onError: function onError(e) {
              setAttributes({
                url: undefined,
                ids: undefined
              });

              _this2.setState({
                editing: true
              });

              noticeOperations.createErrorNotice(e);
            },
            allowedTypes: ALLOWED_MEDIA_TYPES
          });
        }
      }
    }
  }, {
    key: "toggleAttribute",
    value: function toggleAttribute(attribute) {
      var _this3 = this;

      return function (newValue) {
        if (newValue === window.wvplVars.options[attribute]) newValue = undefined;

        _this3.props.setAttributes(_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()({}, attribute, newValue));
      };
    }
  }, {
    key: "updateInstance",
    value: function updateInstance() {
      var _this4 = this;

      return function () {
        window.WavePlayer.stop();
        window.WavePlayer.loadInstances('[data-block="' + _this4.props.clientId + '"]');
      };
    }
  }, {
    key: "onSelectURL",
    value: function onSelectURL(newURL) {
      var _this$props2 = this.props,
          attributes = _this$props2.attributes,
          setAttributes = _this$props2.setAttributes;
      var url = attributes.url;

      if (newURL !== url) {
        setAttributes({
          url: newURL,
          ids: undefined
        });
        url = newURL;
      }

      this.setState({
        editing: false
      });
    }
  }, {
    key: "onUploadError",
    value: function onUploadError(message) {
      var noticeOperations = this.props.noticeOperations;
      noticeOperations.removeAllNotices();
      noticeOperations.createErrorNotice(message);
    }
  }, {
    key: "getAutoplayHelp",
    value: function getAutoplayHelp(checked) {
      return checked ? Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Note: Autoplaying audio may cause usability issues for some visitors.') : null;
    }
  }, {
    key: "render",
    value: function render() {
      var _this5 = this;

      var _this$props3 = this.props,
          setAttributes = _this$props3.setAttributes,
          isSelected = _this$props3.isSelected,
          className = _this$props3.className,
          noticeOperations = _this$props3.noticeOperations,
          noticeUI = _this$props3.noticeUI,
          attributes = _this$props3.attributes;
      var caption = attributes.caption,
          autoplay = attributes.autoplay,
          repeat = attributes.repeat,
          shuffle = attributes.shuffle,
          preload = attributes.preload,
          url = attributes.url,
          ids = attributes.ids,
          skin = attributes.skin,
          palette = attributes.palette,
          size = attributes.size,
          style = attributes.style,
          shape = attributes.shape,
          wave_mode = attributes.wave_mode,
          gap_width = attributes.gap_width,
          cursor_width = attributes.cursor_width,
          override_wave_colors = attributes.override_wave_colors,
          wave_color = attributes.wave_color,
          wave_color_2 = attributes.wave_color_2,
          progress_color = attributes.progress_color,
          progress_color_2 = attributes.progress_color_2,
          cursor_color = attributes.cursor_color,
          cursor_color_2 = attributes.cursor_color_2,
          wave_animation = attributes.wave_animation,
          wave_normalization = attributes.wave_normalization,
          amp_freq_ratio = attributes.amp_freq_ratio;
      var editing = this.state.editing;

      var switchToEditing = function switchToEditing() {
        _this5.setState({
          editing: true
        });
      };

      var skinSupport = function skinSupport(property) {
        var support = window.wvplVars.skins.find(function (s) {
          return s.skin === skin;
        }).support;
        return support && support.includes(property);
      };

      var onSelectAudio = function onSelectAudio(media) {
        if (!media) {
          setAttributes({
            url: undefined,
            ids: undefined
          });
          switchToEditing();
          return;
        }

        var newIDs = media.map(function (_ref3) {
          var id = _ref3.id;
          return id;
        }).filter(function (id) {
          return id;
        }).join(',');
        setAttributes({
          url: undefined,
          ids: newIDs
        });

        _this5.setState({
          ids: newIDs,
          editing: false
        });
      };

      if (editing) {
        var mediaIDs = ids || '';
        mediaIDs = mediaIDs.split(',').filter(function (id) {
          return id;
        }).map(function (id) {
          return {
            id: Number(id)
          };
        });
        var value = ids ? mediaIDs : {
          src: url
        };
        return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_13__["MediaPlaceholder"], {
          labels: {
            title: 'WavePlayer',
            instructions: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Drag or upload your audio files, or select them from your Media library.')
          },
          icon: Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_13__["BlockIcon"], {
            icon: _icon__WEBPACK_IMPORTED_MODULE_15__["default"]
          }),
          className: className,
          onSelect: onSelectAudio,
          onSelectURL: this.onSelectURL,
          accept: "audio/*",
          allowedTypes: ALLOWED_MEDIA_TYPES,
          multiple: 'add',
          value: value,
          notices: noticeUI,
          onError: this.onUploadError
        });
      }
      /* eslint-disable jsx-a11y/no-static-element-interactions, jsx-a11y/onclick-has-role, jsx-a11y/click-events-have-key-events */


      return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["Fragment"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_13__["BlockControls"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["Toolbar"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["Button"], {
        className: "components-icon-button components-toolbar__control",
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Edit WavePlayer'),
        onClick: switchToEditing,
        icon: "edit"
      }))), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_13__["InspectorControls"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["PanelBody"], {
        title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Player Settings'),
        initialOpen: false
      }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["ToggleControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Autoplay'),
        onChange: this.toggleAttribute('autoplay'),
        checked: autoplay
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["ToggleControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Repeat'),
        onChange: this.toggleAttribute('repeat'),
        checked: repeat
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["ToggleControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Shuffle'),
        onChange: this.toggleAttribute('shuffle'),
        checked: shuffle
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["SelectControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Preload'),
        value: undefined !== preload ? preload : 'none' // `undefined` is required for the preload attribute to be unset.
        ,
        onChange: function onChange(value) {
          return setAttributes({
            'preload': 'none' !== value ? value : undefined
          });
        },
        options: [{
          value: 'auto',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Auto')
        }, {
          value: 'metadata',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Metadata')
        }, {
          value: 'none',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('None')
        }]
      })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["PanelBody"], {
        title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Visual Aspect'),
        initialOpen: false
      }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["SelectControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Skin'),
        value: undefined !== skin ? skin : 'w3-standard',
        onChange: function onChange(value) {
          return setAttributes({
            skin: value
          });
        },
        options: window.wvplVars.skins.map(function (s) {
          return {
            value: s.skin,
            label: s.name
          };
        })
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["SelectControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Palette'),
        value: undefined !== palette ? palette : '',
        onChange: function onChange(value) {
          return setAttributes({
            palette: value
          });
        },
        options: window.wvplVars.palettes.map(function (p) {
          return {
            value: p.colors,
            label: p.name
          };
        })
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["ToggleControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Palette overrides default waveform colors', 'waveplayer'),
        onChange: this.toggleAttribute('override_wave_colors'),
        checked: override_wave_colors
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["SelectControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Style'),
        value: undefined !== style ? style : 'light',
        onChange: function onChange(value) {
          return setAttributes({
            style: value
          });
        },
        options: [{
          value: 'light',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Light')
        }, {
          value: 'dark',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Dark')
        }, {
          value: 'color-scheme',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Follow device color scheme')
        }]
      }), skinSupport('size') && Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["SelectControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Size'),
        value: undefined !== size ? size : 'lg',
        onChange: function onChange(value) {
          return setAttributes({
            size: value
          });
        },
        options: [{
          value: 'lg',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Large')
        }, {
          value: 'md',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Medium')
        }, {
          value: 'sm',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Small')
        }, {
          value: 'xs',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Extra Small')
        }]
      }), skinSupport('shape') && Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["SelectControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Shape'),
        value: undefined !== shape ? shape : 'square',
        onChange: function onChange(value) {
          return setAttributes({
            shape: value
          });
        },
        options: [{
          value: 'square',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Square')
        }, {
          value: 'circle',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Circle')
        }, {
          value: 'rounded',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Rounded')
        }]
      })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["PanelBody"], {
        title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Waveform Settings'),
        initialOpen: false
      }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["RangeControl"], {
        label: "Bar width",
        value: Number(wave_mode),
        onChange: function onChange(value) {
          return setAttributes({
            wave_mode: value
          });
        },
        min: 1,
        max: 10
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["RangeControl"], {
        label: "Gap width",
        value: Number(gap_width),
        onChange: function onChange(value) {
          return setAttributes({
            gap_width: value
          });
        },
        min: 0,
        max: 10
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["SelectControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Cursor Width'),
        value: cursor_width,
        onChange: function onChange(value) {
          return setAttributes({
            cursor_width: value
          });
        },
        options: [{
          value: '0',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('No cursor')
        }, {
          value: '1',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Thin')
        }, {
          value: '2',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Normal')
        }, {
          value: '4',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Thick')
        }]
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["ToggleControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Visual Normalization', 'waveplayer'),
        onChange: this.toggleAttribute('wave_normalization'),
        checked: wave_normalization
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["SelectControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Visual Compression', 'waveplayer'),
        value: Number(wave_animation),
        onChange: function onChange(value) {
          return setAttributes({
            wave_animation: value
          });
        },
        options: [{
          value: '1',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('None (linear)', 'waveplayer')
        }, {
          value: '2',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Moderate (square)', 'waveplayer')
        }, {
          value: '3',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('High (cubic)', 'waveplayer')
        }, {
          value: '4',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Very high (4th Order)', 'waveplayer')
        }, {
          value: '5',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Extreme (5th order)', 'waveplayer')
        }]
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["SelectControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Visual Asymmetry', 'waveplayer'),
        value: Number(wave_animation),
        onChange: function onChange(value) {
          return setAttributes({
            wave_animation: value
          });
        },
        options: [{
          value: '1',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('1/2 + 1/2', 'waveplayer')
        }, {
          value: '2',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('2/3 + 1/3', 'waveplayer')
        }, {
          value: '3',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('3/4 + 1/4', 'waveplayer')
        }, {
          value: '4',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('4/5 + 1/5', 'waveplayer')
        }, {
          value: '99999',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Top Only', 'waveplayer')
        }, {
          value: '0.00001',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Bottom Only', 'waveplayer')
        }]
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["SelectControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Wave Animation', 'waveplayer'),
        value: Number(wave_animation),
        onChange: function onChange(value) {
          return setAttributes({
            wave_animation: value
          });
        },
        options: [{
          value: '1',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('No animation', 'waveplayer')
        }, {
          value: '0.85',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Slow', 'waveplayer')
        }, {
          value: '0.7',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Smooth', 'waveplayer')
        }, {
          value: '0.55',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Normal', 'waveplayer')
        }, {
          value: '0.4',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Fast', 'waveplayer')
        }, {
          value: '0.25',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Hectic', 'waveplayer')
        }]
      }), Number(wave_animation) < 1 && Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["SelectControl"], {
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Amp/Freq Balance', 'waveplayer'),
        value: Number(amp_freq_ratio),
        onChange: function onChange(value) {
          return setAttributes({
            amp_freq_ratio: value
          });
        },
        options: [{
          value: '4',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Mostly amplitude', 'waveplayer')
        }, {
          value: '2',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('More amplitude', 'waveplayer')
        }, {
          value: '1',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Equally', 'waveplayer')
        }, {
          value: '0.5',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('More Frequency', 'waveplayer')
        }, {
          value: '0.25',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Mostly Frequency', 'waveplayer')
        }, {
          value: '0.000061',
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Frequency only', 'waveplayer')
        }]
      })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_13__["PanelColorSettings"], {
        title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Waveform Colors', 'waveplayer'),
        initialOpen: false,
        colorSettings: [{
          value: wave_color,
          onChange: function onChange(colorValue) {
            return setAttributes({
              'wave_color': colorValue
            });
          },
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Waveform Color 1', 'waveplayer')
        }, {
          value: wave_color_2,
          onChange: function onChange(colorValue) {
            return setAttributes({
              'wave_color_2': colorValue
            });
          },
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Waveform Color 2', 'waveplayer')
        }]
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_13__["PanelColorSettings"], {
        title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Progress Colors', 'waveplayer'),
        initialOpen: false,
        colorSettings: [{
          value: progress_color,
          onChange: function onChange(colorValue) {
            return setAttributes({
              'progress_color': colorValue
            });
          },
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Progress Color 1', 'waveplayer')
        }, {
          value: progress_color_2,
          onChange: function onChange(colorValue) {
            return setAttributes({
              'progress_color_2': colorValue
            });
          },
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Progress Color 2', 'waveplayer')
        }]
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_13__["PanelColorSettings"], {
        title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Cursor Colors', 'waveplayer'),
        initialOpen: false,
        colorSettings: [{
          value: cursor_color,
          onChange: function onChange(colorValue) {
            return setAttributes({
              'cursor_color': colorValue
            });
          },
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Cursor Color 1', 'waveplayer')
        }, {
          value: cursor_color_2,
          onChange: function onChange(colorValue) {
            return setAttributes({
              'cursor_color_2': colorValue
            });
          },
          label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Cursor Color 2', 'waveplayer')
        }]
      })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["Disabled"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(_waveplayer_ssr__WEBPACK_IMPORTED_MODULE_9__["default"], {
        className: className,
        block: "waveplayer/block",
        attributes: this.props.attributes,
        onChange: this.updateInstance()
      })));
      /* eslint-enable jsx-a11y/no-static-element-interactions, jsx-a11y/onclick-has-role, jsx-a11y/click-events-have-key-events */
    }
  }]);

  return WavePlayer;
}(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["Component"]);

/* harmony default export */ __webpack_exports__["default"] = (Object(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["withNotices"])(WavePlayer));

/***/ }),

/***/ "./src/icon.js":
/*!*********************!*\
  !*** ./src/icon.js ***!
  \*********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */

/* harmony default export */ __webpack_exports__["default"] = (Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  viewBox: "0 0 20 20",
  xmlns: "http://www.w3.org/2000/svg"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  d: "M1.5 8l2 0l0 4l-2 0zM4.5 5l2 0l0 10l-2 0zM7.5 7l2 0l0 6l-2 0zM10.5 3l2 0l0 14l-2 0zM13.5 6l2 0l0 8l-2 0zM16.5 9l2 0l0 2l-2 0z"
})));

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! exports provided: metadata, name */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "name", function() { return name; });
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./edit */ "./src/edit.js");
/* harmony import */ var _icon__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./icon */ "./src/icon.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./block.json */ "./src/block.json");
var _block_json__WEBPACK_IMPORTED_MODULE_3___namespace = /*#__PURE__*/Object.assign({}, _block_json__WEBPACK_IMPORTED_MODULE_3__, {"default": _block_json__WEBPACK_IMPORTED_MODULE_3__});
/* harmony reexport (default from named exports) */ __webpack_require__.d(__webpack_exports__, "metadata", function() { return _block_json__WEBPACK_IMPORTED_MODULE_3__; });
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./save */ "./src/save.js");
/* harmony import */ var _transforms__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./transforms */ "./src/transforms.js");
/**
 * WordPress dependencies
 */

/**
 * Internal dependencies
 */






var name = _block_json__WEBPACK_IMPORTED_MODULE_3__.name;

var registerBlockType = wp.blocks.registerBlockType;
var options = window.wvplVars.options;
registerBlockType('waveplayer/block', {
  title: 'WavePlayer',
  description: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__["__"])('Insert a WavePlayer instance.'),
  icon: _icon__WEBPACK_IMPORTED_MODULE_2__["default"],
  category: 'common',
  attributes: {
    ids: {
      type: 'string'
    },
    url: {
      type: 'string'
    },
    skin: {
      type: 'string',
      default: options.skin
    },
    palette: {
      type: 'string',
      default: options.default_palette
    },
    override_wave_colors: {
      type: 'boolean',
      default: options.override_wave_colors === '1'
    },
    size: {
      type: 'string',
      default: options.size
    },
    style: {
      type: 'string',
      default: options.style
    },
    shape: {
      type: 'string',
      default: options.shape
    },
    wave_mode: {
      type: 'string',
      default: options.wave_mode
    },
    gap_width: {
      type: 'string',
      default: options.gap_width
    },
    cursor_width: {
      type: 'string',
      default: options.cursor_width
    },
    wave_color: {
      type: 'string',
      default: options.wave_color
    },
    wave_color_2: {
      type: 'string',
      default: options.wave_color_2
    },
    progress_color: {
      type: 'string',
      default: options.progress_color
    },
    progress_color_2: {
      type: 'string',
      default: options.progress_color_2
    },
    cursor_color: {
      type: 'string',
      default: options.cursor_color
    },
    cursor_color_2: {
      type: 'string',
      default: options.cursor_color_2
    },
    wave_animation: {
      type: 'float',
      default: options.wave_animation
    },
    amp_freq_ratio: {
      type: 'float',
      default: options.amp_freq_ratio
    },
    wave_normalization: {
      type: 'boolean',
      default: options.wave_normalization === '1'
    },
    autoplay: {
      type: 'boolean',
      default: options.autoplay === '1'
    },
    repeat: {
      type: 'boolean',
      default: options.repeat === '1'
    },
    shuffle: {
      type: 'boolean',
      default: options.shuffle === '1'
    }
  },
  edit: _edit__WEBPACK_IMPORTED_MODULE_1__["default"],
  save: _save__WEBPACK_IMPORTED_MODULE_4__["default"],
  transforms: _transforms__WEBPACK_IMPORTED_MODULE_5__["default"]
});

/***/ }),

/***/ "./src/save.js":
/*!*********************!*\
  !*** ./src/save.js ***!
  \*********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return save; });
function save(_ref) {
  var attributes = _ref.attributes;
  return null;
}

/***/ }),

/***/ "./src/transforms.js":
/*!***************************!*\
  !*** ./src/transforms.js ***!
  \***************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blob__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blob */ "@wordpress/blob");
/* harmony import */ var _wordpress_blob__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blob__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__);
/**
 * WordPress dependencies
 */


var transforms = {
  from: [{
    type: 'files',
    isMatch: function isMatch(files) {
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = files[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var file = _step.value;
          if (file.type.indexOf('audio/') !== 0) return false;
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return != null) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      return true;
    },
    transform: function transform(files) {
      var file = files[0]; // We don't need to upload the media directly here
      // It's already done as part of the `componentDidMount`
      // in the audio block

      var block = Object(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__["createBlock"])('waveplayer/block', {
        src: Object(_wordpress_blob__WEBPACK_IMPORTED_MODULE_0__["createBlobURL"])(file)
      });
      return block;
    }
  }, {
    type: 'block',
    blocks: ['core/audio'],
    transform: function transform(attributes) {
      return Object(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__["createBlock"])('waveplayer/block', {
        url: attributes.src
      });
    }
  }, {
    type: 'shortcode',
    tag: 'playlist',
    attributes: {
      'ids': {
        type: 'string',
        shortcode: function shortcode(_ref) {
          var ids = _ref.named.ids;
          return ids;
        }
      }
    }
  }, {
    type: 'shortcode',
    tag: 'waveplayer',
    attributes: {
      'ids': {
        type: 'string',
        shortcode: function shortcode(_ref2) {
          var ids = _ref2.named.ids;
          return ids;
        }
      },
      'url': {
        type: 'string',
        shortcode: function shortcode(_ref3) {
          var url = _ref3.named.url;
          return url;
        }
      },
      'size': {
        type: 'string',
        shortcode: function shortcode(_ref4) {
          var size = _ref4.named.size;
          return size;
        }
      },
      'shape': {
        type: 'string',
        shortcode: function shortcode(_ref5) {
          var shape = _ref5.named.shape;
          return shape;
        }
      },
      'style': {
        type: 'string',
        shortcode: function shortcode(_ref6) {
          var style = _ref6.named.style;
          return style;
        }
      },
      'repeat': {
        type: 'string',
        shortcode: function shortcode(_ref7) {
          var repeat = _ref7.named.repeat;
          return repeat;
        }
      },
      'autoplay': {
        type: 'string',
        shortcode: function shortcode(_ref8) {
          var autoplay = _ref8.named.autoplay;
          return autoplay;
        }
      },
      'music_genres': {
        type: 'string',
        shortcode: function shortcode(_ref9) {
          var music_genres = _ref9.named.music_genres;
          return music_genres;
        }
      },
      'wave_mode': {
        type: 'string',
        shortcode: function shortcode(_ref10) {
          var wave_mode = _ref10.named.wave_mode;
          return wave_mode;
        }
      },
      'gap_width': {
        type: 'string',
        shortcode: function shortcode(_ref11) {
          var gap_width = _ref11.named.gap_width;
          return gap_width;
        }
      },
      'wave_color': {
        type: 'string',
        shortcode: function shortcode(_ref12) {
          var wave_color = _ref12.named.wave_color;
          return wave_color;
        }
      },
      'wave_color_2': {
        type: 'string',
        shortcode: function shortcode(_ref13) {
          var wave_color_2 = _ref13.named.wave_color_2;
          return wave_color_2;
        }
      },
      'progress_color': {
        type: 'string',
        shortcode: function shortcode(_ref14) {
          var progress_color = _ref14.named.progress_color;
          return progress_color;
        }
      },
      'progress_color_2': {
        type: 'string',
        shortcode: function shortcode(_ref15) {
          var progress_color_2 = _ref15.named.progress_color_2;
          return progress_color_2;
        }
      },
      'cursor_color': {
        type: 'string',
        shortcode: function shortcode(_ref16) {
          var cursor_color = _ref16.named.cursor_color;
          return cursor_color;
        }
      },
      'cursor_color_2': {
        type: 'string',
        shortcode: function shortcode(_ref17) {
          var cursor_color_2 = _ref17.named.cursor_color_2;
          return cursor_color_2;
        }
      },
      'cursor_width': {
        type: 'string',
        shortcode: function shortcode(_ref18) {
          var cursor_width = _ref18.named.cursor_width;
          return cursor_width;
        }
      }
    }
  }]
};
/* harmony default export */ __webpack_exports__["default"] = (transforms);

/***/ }),

/***/ "./src/waveplayer-ssr/index.js":
/*!*************************************!*\
  !*** ./src/waveplayer-ssr/index.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/extends.js");
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/defineProperty.js");
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/objectWithoutProperties */ "./node_modules/@babel/runtime/helpers/objectWithoutProperties.js");
/* harmony import */ var _babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _waveplayer_ssr__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./waveplayer-ssr */ "./src/waveplayer-ssr/waveplayer-ssr.js");





function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1___default()(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

/**
 * WordPress dependencies
 */


/**
 * Internal dependencies
 */


/**
 * Constants
 */

var EMPTY_OBJECT = {};
/* harmony default export */ __webpack_exports__["default"] = (Object(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__["withSelect"])(function (select) {
  var coreEditorSelect = select('core/editor');

  if (coreEditorSelect) {
    var currentPostId = coreEditorSelect.getCurrentPostId();

    if (currentPostId) {
      return {
        currentPostId: currentPostId
      };
    }
  }

  return EMPTY_OBJECT;
})(function (_ref) {
  var _ref$urlQueryArgs = _ref.urlQueryArgs,
      urlQueryArgs = _ref$urlQueryArgs === void 0 ? EMPTY_OBJECT : _ref$urlQueryArgs,
      currentPostId = _ref.currentPostId,
      props = _babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_2___default()(_ref, ["urlQueryArgs", "currentPostId"]);

  var newUrlQueryArgs = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__["useMemo"])(function () {
    if (!currentPostId) {
      return urlQueryArgs;
    }

    return _objectSpread({
      post_id: currentPostId
    }, urlQueryArgs);
  }, [currentPostId, urlQueryArgs]);
  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__["createElement"])(_waveplayer_ssr__WEBPACK_IMPORTED_MODULE_5__["default"], _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0___default()({
    urlQueryArgs: newUrlQueryArgs
  }, props));
}));

/***/ }),

/***/ "./src/waveplayer-ssr/waveplayer-ssr.js":
/*!**********************************************!*\
  !*** ./src/waveplayer-ssr/waveplayer-ssr.js ***!
  \**********************************************/
/*! exports provided: rendererPath, WavePlayerServerSideRender, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "rendererPath", function() { return rendererPath; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "WavePlayerServerSideRender", function() { return WavePlayerServerSideRender; });
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "./node_modules/@babel/runtime/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/createClass */ "./node_modules/@babel/runtime/helpers/createClass.js");
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/helpers/getPrototypeOf */ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime/helpers/inherits */ "./node_modules/@babel/runtime/helpers/inherits.js");
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/defineProperty.js");
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _wordpress_url__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @wordpress/url */ "@wordpress/url");
/* harmony import */ var _wordpress_url__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_wordpress_url__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__);








function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_5___default()(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

/**
 * External dependencies
 */

/**
 * WordPress dependencies
 */






function rendererPath(block) {
  var attributes = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
  var urlQueryArgs = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
  return Object(_wordpress_url__WEBPACK_IMPORTED_MODULE_10__["addQueryArgs"])("/wp/v2/block-renderer/".concat(block), _objectSpread({
    context: 'edit'
  }, null !== attributes ? {
    attributes: attributes
  } : {}, {}, urlQueryArgs));
}
var WavePlayerServerSideRender =
/*#__PURE__*/
function (_Component) {
  _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_4___default()(WavePlayerServerSideRender, _Component);

  function WavePlayerServerSideRender(props) {
    var _this;

    _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, WavePlayerServerSideRender);

    _this = _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_2___default()(this, _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_3___default()(WavePlayerServerSideRender).call(this, props));
    _this.state = {
      response: null
    };
    return _this;
  }

  _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(WavePlayerServerSideRender, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      this.isStillMounted = true;
      this.fetch(this.props); // Only debounce once the initial fetch occurs to ensure that the first
      // renders show data as soon as possible.

      this.fetch = Object(lodash__WEBPACK_IMPORTED_MODULE_7__["debounce"])(this.fetch, 500);
    }
  }, {
    key: "componentWillUnmount",
    value: function componentWillUnmount() {
      this.isStillMounted = false;
    }
  }, {
    key: "componentDidUpdate",
    value: function componentDidUpdate(prevProps, prevState) {
      if (!Object(lodash__WEBPACK_IMPORTED_MODULE_7__["isEqual"])(prevProps.attributes, this.props.attributes)) {
        this.fetch(this.props);
      }
    }
  }, {
    key: "fetch",
    value: function fetch(props) {
      var _this2 = this;

      if (!this.isStillMounted) {
        return;
      }

      if (null !== this.state.response) {
        this.setState({
          response: null
        });
      }

      var block = props.block,
          _props$attributes = props.attributes,
          attributes = _props$attributes === void 0 ? null : _props$attributes,
          _props$urlQueryArgs = props.urlQueryArgs,
          urlQueryArgs = _props$urlQueryArgs === void 0 ? {} : _props$urlQueryArgs;
      var path = rendererPath(block, attributes, urlQueryArgs); // Store the latest fetch request so that when we process it, we can
      // check if it is the current request, to avoid race conditions on slow networks.

      var fetchRequest = this.currentFetchRequest = _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_9___default()({
        path: path
      }).then(function (response) {
        if (_this2.isStillMounted && fetchRequest === _this2.currentFetchRequest && response) {
          _this2.setState({
            response: response.rendered
          });

          if (_this2.props.onChange) {
            _this2.props.onChange();
          }
        }
      }).catch(function (error) {
        if (_this2.isStillMounted && fetchRequest === _this2.currentFetchRequest) {
          _this2.setState({
            response: {
              error: true,
              errorMsg: error.message
            }
          });
        }
      });
      return fetchRequest;
    }
  }, {
    key: "render",
    value: function render() {
      var response = this.state.response;
      var className = this.props.className;

      if (response === '') {
        return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_6__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["Placeholder"], {
          className: className
        }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Block rendered as empty.'));
      } else if (!response) {
        return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_6__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["Placeholder"], {
          className: className
        }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_6__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["Spinner"], null));
      } else if (response.error) {
        // translators: %s: error message describing the problem
        var errorMessage = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["sprintf"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Error loading block: %s'), response.errorMsg);
        return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_6__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_11__["Placeholder"], {
          className: className
        }, errorMessage);
      }

      return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_6__["createElement"])(_wordpress_element__WEBPACK_IMPORTED_MODULE_6__["RawHTML"], {
        key: "html",
        className: className
      }, response);
    }
  }]);

  return WavePlayerServerSideRender;
}(_wordpress_element__WEBPACK_IMPORTED_MODULE_6__["Component"]);
/* harmony default export */ __webpack_exports__["default"] = (WavePlayerServerSideRender);

/***/ }),

/***/ "@wordpress/api-fetch":
/*!*******************************************!*\
  !*** external {"this":["wp","apiFetch"]} ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["apiFetch"]; }());

/***/ }),

/***/ "@wordpress/blob":
/*!***************************************!*\
  !*** external {"this":["wp","blob"]} ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["blob"]; }());

/***/ }),

/***/ "@wordpress/block-editor":
/*!**********************************************!*\
  !*** external {"this":["wp","blockEditor"]} ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["blockEditor"]; }());

/***/ }),

/***/ "@wordpress/blocks":
/*!*****************************************!*\
  !*** external {"this":["wp","blocks"]} ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["blocks"]; }());

/***/ }),

/***/ "@wordpress/components":
/*!*********************************************!*\
  !*** external {"this":["wp","components"]} ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["components"]; }());

/***/ }),

/***/ "@wordpress/data":
/*!***************************************!*\
  !*** external {"this":["wp","data"]} ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["data"]; }());

/***/ }),

/***/ "@wordpress/editor":
/*!*****************************************!*\
  !*** external {"this":["wp","editor"]} ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["editor"]; }());

/***/ }),

/***/ "@wordpress/element":
/*!******************************************!*\
  !*** external {"this":["wp","element"]} ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["element"]; }());

/***/ }),

/***/ "@wordpress/i18n":
/*!***************************************!*\
  !*** external {"this":["wp","i18n"]} ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["i18n"]; }());

/***/ }),

/***/ "@wordpress/url":
/*!**************************************!*\
  !*** external {"this":["wp","url"]} ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["url"]; }());

/***/ }),

/***/ "lodash":
/*!*************************!*\
  !*** external "lodash" ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = lodash;

/***/ })

/******/ });
//# sourceMappingURL=index.js.map