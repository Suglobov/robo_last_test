/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
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
/******/ 	// identity function for calling harmory imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmory exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		Object.defineProperty(exports, name, {
/******/ 			configurable: false,
/******/ 			enumerable: true,
/******/ 			get: getter
/******/ 		});
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
/******/ ([
/* 0 */
/***/ function(module, exports) {

eval("/**\n * First we will load all of this project's JavaScript dependencies which\n * include Vue and Vue Resource. This gives a great starting point for\n * building robust, powerful web applications using Vue and Laravel.\n */\n\n// require('./bootstrap');\n\n/**\n * Next, we will create a fresh Vue application instance and attach it to\n * the body of the page. From here, you may begin adding components to\n * the application, or feel free to tweak this setup for your needs.\n */\n\n// Vue.component('example', require('./components/Example.vue'));\n//\n// const app = new Vue({\n//     el: '#app'\n// });\n\nvar zeroPlus = function (x) { return x < 10 ? '0' + x : x; };\nvar dateFotmatInput = function (date) { return date.getFullYear() + '-'\n    + zeroPlus(date.getMonth() + 1) + '-'\n    + zeroPlus(date.getDate()) + 'T'\n    + zeroPlus(date.getHours()) + ':'\n    + '00:00'; };\n\nwindow.addEventListener('load', function () {\n    var form = document.getElementById('operationForm');\n    var date1 = document.getElementById('date1');\n    var dateNow = document.getElementById('dateNow');\n\n    var testInput = function (changeVal) {\n        if ( changeVal === void 0 ) changeVal = false;\n\n        var now = new Date();\n        now.setHours(now.getHours() + 1);\n        date1.min = dateFotmatInput(now);\n        if (changeVal) {\n            date1.value = dateFotmatInput(now);\n        }\n    };\n\n    testInput(true);\n    setInterval(testInput, 60000);\n\n    form.addEventListener('submit', function () {\n        dateNow.value = dateFotmatInput(new Date());\n    });\n});\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL2FwcC5qcz84YjY3Il0sInNvdXJjZXNDb250ZW50IjpbIi8qKlxuICogRmlyc3Qgd2Ugd2lsbCBsb2FkIGFsbCBvZiB0aGlzIHByb2plY3QncyBKYXZhU2NyaXB0IGRlcGVuZGVuY2llcyB3aGljaFxuICogaW5jbHVkZSBWdWUgYW5kIFZ1ZSBSZXNvdXJjZS4gVGhpcyBnaXZlcyBhIGdyZWF0IHN0YXJ0aW5nIHBvaW50IGZvclxuICogYnVpbGRpbmcgcm9idXN0LCBwb3dlcmZ1bCB3ZWIgYXBwbGljYXRpb25zIHVzaW5nIFZ1ZSBhbmQgTGFyYXZlbC5cbiAqL1xuXG4vLyByZXF1aXJlKCcuL2Jvb3RzdHJhcCcpO1xuXG4vKipcbiAqIE5leHQsIHdlIHdpbGwgY3JlYXRlIGEgZnJlc2ggVnVlIGFwcGxpY2F0aW9uIGluc3RhbmNlIGFuZCBhdHRhY2ggaXQgdG9cbiAqIHRoZSBib2R5IG9mIHRoZSBwYWdlLiBGcm9tIGhlcmUsIHlvdSBtYXkgYmVnaW4gYWRkaW5nIGNvbXBvbmVudHMgdG9cbiAqIHRoZSBhcHBsaWNhdGlvbiwgb3IgZmVlbCBmcmVlIHRvIHR3ZWFrIHRoaXMgc2V0dXAgZm9yIHlvdXIgbmVlZHMuXG4gKi9cblxuLy8gVnVlLmNvbXBvbmVudCgnZXhhbXBsZScsIHJlcXVpcmUoJy4vY29tcG9uZW50cy9FeGFtcGxlLnZ1ZScpKTtcbi8vXG4vLyBjb25zdCBhcHAgPSBuZXcgVnVlKHtcbi8vICAgICBlbDogJyNhcHAnXG4vLyB9KTtcblxuY29uc3QgemVyb1BsdXMgPSB4ID0+IHggPCAxMCA/ICcwJyArIHggOiB4O1xuY29uc3QgZGF0ZUZvdG1hdElucHV0ID0gZGF0ZSA9PlxuICAgIGRhdGUuZ2V0RnVsbFllYXIoKSArICctJ1xuICAgICsgemVyb1BsdXMoZGF0ZS5nZXRNb250aCgpICsgMSkgKyAnLSdcbiAgICArIHplcm9QbHVzKGRhdGUuZ2V0RGF0ZSgpKSArICdUJ1xuICAgICsgemVyb1BsdXMoZGF0ZS5nZXRIb3VycygpKSArICc6J1xuICAgICsgJzAwOjAwJztcblxud2luZG93LmFkZEV2ZW50TGlzdGVuZXIoJ2xvYWQnLCAoKSA9PiB7XG4gICAgbGV0IGZvcm0gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnb3BlcmF0aW9uRm9ybScpO1xuICAgIGxldCBkYXRlMSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdkYXRlMScpO1xuICAgIGxldCBkYXRlTm93ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2RhdGVOb3cnKTtcblxuICAgIGNvbnN0IHRlc3RJbnB1dCA9IChjaGFuZ2VWYWwgPSBmYWxzZSkgPT4ge1xuICAgICAgICBsZXQgbm93ID0gbmV3IERhdGUoKTtcbiAgICAgICAgbm93LnNldEhvdXJzKG5vdy5nZXRIb3VycygpICsgMSk7XG4gICAgICAgIGRhdGUxLm1pbiA9IGRhdGVGb3RtYXRJbnB1dChub3cpO1xuICAgICAgICBpZiAoY2hhbmdlVmFsKSB7XG4gICAgICAgICAgICBkYXRlMS52YWx1ZSA9IGRhdGVGb3RtYXRJbnB1dChub3cpO1xuICAgICAgICB9XG4gICAgfTtcblxuICAgIHRlc3RJbnB1dCh0cnVlKTtcbiAgICBzZXRJbnRlcnZhbCh0ZXN0SW5wdXQsIDYwMDAwKTtcblxuICAgIGZvcm0uYWRkRXZlbnRMaXN0ZW5lcignc3VibWl0JywgKCkgPT4ge1xuICAgICAgICBkYXRlTm93LnZhbHVlID0gZGF0ZUZvdG1hdElucHV0KG5ldyBEYXRlKCkpO1xuICAgIH0pO1xufSk7XG5cblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gcmVzb3VyY2VzL2Fzc2V0cy9qcy9hcHAuanMiXSwibWFwcGluZ3MiOiJBQUFBOzs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQW9CQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Iiwic291cmNlUm9vdCI6IiJ9");

/***/ }
/******/ ]);