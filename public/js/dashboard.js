/******/ (() => { // webpackBootstrap
/*!******************************************!*\
  !*** ./resources/assets/js/dashboard.js ***!
  \******************************************/
document.addEventListener('alpine:init', function () {
  Alpine.data('accordion', function () {
    return {
      isOpen: window.innerWidth >= 768,
      toggle: function toggle() {
        this.isOpen = !this.isOpen;
      },
      checkWidth: function checkWidth() {
        this.isOpen = window.innerWidth >= 768;
      }
    };
  });
  Alpine.data('sidepanel', function () {
    return {
      sidePanel: '',
      sidePanelTitle: '',
      useComponent: false,
      componentName: '',
      dateLabel: '',
      toggleSidePanel: function toggleSidePanel() {
        var component = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
        var title = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
        var record = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
        console.log('yes panrel');
        this.sidePanelTitle = title;
        this.sidePanel = !this.sidePanel;
        if (component !== '') {
          this.useComponent = true;
          this.componentName = component;
        } else {
          this.useComponent = false;
        }
        if (record !== null) {
          $wire.sidePanelModel(record);
          $wire.resolvePanelModel(record);
          console.log(record);
        }
      },
      closePanel: function closePanel() {
        this.sidePanel = !this.sidePanel;
      }
    };
  });
  Alpine.data('image', function () {
    return {
      imgsrc: null,
      modelImageId: '',
      previewImage: function previewImage(modelId) {
        var _this = this;
        this.modelImageId = modelId;
        var file = this.$refs.uploadedImage.files[0];
        var filename = file.name;
        var form = document.getElementById('imageForm');
        if (!file || file.type.indexOf('image/') === -1) return;
        this.imgsrc = null;
        var reader = new FileReader();
        reader.onload = function (e) {
          _this.imgsrc = e.target.result;
        };
        reader.readAsDataURL(file);
        console.log('yes image');
      }
    };
  });

  // Listen to window resize globally
  window.addEventListener('resize', function () {
    document.querySelectorAll('[x-data="accordion()"]').forEach(function (el) {
      Alpine.data('accordion').call(el).__x.$data.checkWidth();
    });
  });
});
/******/ })()
;