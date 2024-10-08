/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/advanced-custom-fields-pro/assets/src/js/_acf-internal-post-type.js":
/*!*********************************************************************************!*\
  !*** ./src/advanced-custom-fields-pro/assets/src/js/_acf-internal-post-type.js ***!
  \*********************************************************************************/
/***/ (() => {

(function ($, undefined) {
  /**
   *  internalPostTypeSettingsManager
   *
   *  Model for handling events in the settings metaboxes of internal post types
   *
   *  @since	6.1
   */
  const internalPostTypeSettingsManager = new acf.Model({
    id: 'internalPostTypeSettingsManager',
    events: {
      'blur .acf_slugify_to_key': 'onChangeSlugify',
      'blur .acf_singular_label': 'onChangeSingularLabel',
      'blur .acf_plural_label': 'onChangePluralLabel'
    },
    onChangeSlugify: function (e, $el) {
      const name = $el.val();
      const $keyInput = $('.acf_slugified_key');

      // render name
      if ($keyInput.val().trim() == '') {
        var slug = acf.applyFilters('generate_field_object_name', acf.strSanitize(name), this);
        $keyInput.val(slug);
      }
    },
    onChangeSingularLabel: function (e, $el) {
      const label = $el.val();
      this.updateLabels(label, 'singular');
    },
    onChangePluralLabel: function (e, $el) {
      const label = $el.val();
      this.updateLabels(label, 'plural');
    },
    updateLabels(label, type) {
      $('[data-label][data-replace="' + type + '"').each((index, element) => {
        $(element).find('input[type="text"]').first().val($(element).data('transform') !== 'none' ? $(element).data('label').replace('%s', label.toLowerCase()) : $(element).data('label').replace('%s', label));
      });
    }
  });

  /**
   *  advancedSettingsMetaboxManager
   *
   *  Screen options functionality for internal post types
   *
   *  @since	6.1
   */
  const advancedSettingsMetaboxManager = new acf.Model({
    id: 'advancedSettingsMetaboxManager',
    wait: 'load',
    events: {
      'change .acf-advanced-settings-toggle': 'onToggleACFAdvancedSettings',
      'change #screen-options-wrap #acf-advanced-settings-hide': 'onToggleScreenOptionsAdvancedSettings'
    },
    initialize: function () {
      this.$screenOptionsToggle = $('#screen-options-wrap #acf-advanced-settings-hide:first');
      this.$ACFAdvancedToggle = $('.acf-advanced-settings-toggle:first');
      this.render();
    },
    isACFAdvancedSettingsChecked: function () {
      // Screen option is hidden by filter.
      if (!this.$ACFAdvancedToggle.length) {
        return false;
      }
      return this.$ACFAdvancedToggle.prop('checked');
    },
    isScreenOptionsAdvancedSettingsChecked: function () {
      // Screen option is hidden by filter.
      if (!this.$screenOptionsToggle.length) {
        return false;
      }
      return this.$screenOptionsToggle.prop('checked');
    },
    onToggleScreenOptionsAdvancedSettings: function () {
      if (this.isScreenOptionsAdvancedSettingsChecked()) {
        if (!this.isACFAdvancedSettingsChecked()) {
          this.$ACFAdvancedToggle.trigger('click');
        }
      } else {
        if (this.isACFAdvancedSettingsChecked()) {
          this.$ACFAdvancedToggle.trigger('click');
        }
      }
    },
    onToggleACFAdvancedSettings: function () {
      if (this.isACFAdvancedSettingsChecked()) {
        if (!this.isScreenOptionsAdvancedSettingsChecked()) {
          this.$screenOptionsToggle.trigger('click');
        }
      } else {
        if (this.isScreenOptionsAdvancedSettingsChecked()) {
          this.$screenOptionsToggle.trigger('click');
        }
      }
    },
    render: function () {
      // On render, sync screen options to ACF's setting.
      this.onToggleACFAdvancedSettings();
    }
  });
  const linkFieldGroupsManger = new acf.Model({
    id: 'linkFieldGroupsManager',
    events: {
      'click .acf-link-field-groups': 'linkFieldGroups'
    },
    linkFieldGroups: function () {
      let popup = false;
      const step1 = function () {
        $.ajax({
          url: acf.get('ajaxurl'),
          data: acf.prepareForAjax({
            action: 'acf/link_field_groups'
          }),
          type: 'post',
          dataType: 'json',
          success: step2
        });
      };
      const step2 = function (response) {
        popup = acf.newPopup({
          title: response.data.title,
          content: response.data.content,
          width: '600px'
        });
        popup.$el.addClass('acf-link-field-groups-popup');
        popup.on('submit', 'form', step3);
      };
      const step3 = function (e) {
        e.preventDefault();
        const $select = popup.$('select');
        const val = $select.val();
        if (!val.length) {
          $select.focus();
          return;
        }
        acf.startButtonLoading(popup.$('.button'));

        // get HTML
        $.ajax({
          url: acf.get('ajaxurl'),
          data: acf.prepareForAjax({
            action: 'acf/link_field_groups',
            field_groups: val
          }),
          type: 'post',
          dataType: 'json',
          success: step4
        });
      };
      const step4 = function (response) {
        popup.content(response.data.content);
        if (wp.a11y && wp.a11y.speak && acf.__) {
          wp.a11y.speak(acf.__('Field groups linked successfully.'), 'polite');
        }
        popup.$('button.acf-close-popup').focus();
      };
      step1();
    }
  });
})(jQuery);

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!********************************************************************************!*\
  !*** ./src/advanced-custom-fields-pro/assets/src/js/acf-internal-post-type.js ***!
  \********************************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _acf_internal_post_type_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_acf-internal-post-type.js */ "./src/advanced-custom-fields-pro/assets/src/js/_acf-internal-post-type.js");
/* harmony import */ var _acf_internal_post_type_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_acf_internal_post_type_js__WEBPACK_IMPORTED_MODULE_0__);

})();

/******/ })()
;
//# sourceMappingURL=acf-internal-post-type.js.map