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
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/index.js":
/***/ (function(module, exports) {

/**
 * 获取host域名
 * @returns
 */
function hostUrl() {
    return location.protocol + '//' + location.host;
}
function goHistoryBack(redirect) {
    if (history.length > 1) {
        window.history.go(-1);
    } else {
        if (!redirect) {
            redirect = hostUrl();
        }
        window.location.href = redirect;
    }
}

// 授权时间选择
$(function () {
    $('.accredit-u').on('change', '.accredit-time', function () {
        va = $(this).val();
        if (va.length == 0) {
            $("input[name='end_time']").val('');
            $("input[name='start_time']").val('');
        } else {
            // 当前时间戳
            var end_time = $('.nowDate').val();
            $("input[name='end_time']").val(end_time);
            if (va == 'seven') {
                var start_time = $('.sevenDate').val();
            } else if (va == 'one-month') {
                var start_time = $('.oneMdate').val();
            } else if (va == 'half-year') {
                var start_time = $('.halfDate').val();
            } else if (va == 'year') {
                var start_time = $('.yearDate').val();
            }
            $("input[name='start_time']").val(start_time);
        }
    });
});

/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/index.js");


/***/ })

/******/ });