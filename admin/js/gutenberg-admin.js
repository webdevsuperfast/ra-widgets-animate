const { addFilter } = wp.hooks;
const { createHigherOrderComponent } = wp.compose;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, SelectControl, TextControl, ToggleControl } = wp.components;
const { __ } = wp.i18n;
const animations = {
  "": __("No Animation"),
  fade: __("Fade"),
  "fade-up": __("Fade Up"),
  "fade-down": __("Fade Down"),
  "fade-left": __("Fade Left"),
  "fade-right": __("Fade Right"),
  "fade-up-right": __("Fade Up Right"),
  "fade-up-left": __("Fade Up Left"),
  "fade-down-right": __("Fade Down Right"),
  "fade-down-left": __("Fade Down Left"),
  "flip-up": __("Flip Up"),
  "flip-down": __("Flip Down"),
  "flip-left": __("Flip Left"),
  "flip-right": __("Flip Right"),
  "slide-up": __("Slide Up"),
  "slide-down": __("Slide Down"),
  "slide-left": __("Slide Left"),
  "slide-right": __("Slide Right"),
  "zoom-in": __("Zoom In"),
  "zoom-in-up": __("Zoom In Up"),
  "zoom-in-down": __("Zoom In Down"),
  "zoom-in-left": __("Zoom In Left"),
  "zoom-in-right": __("Zoom In Right"),
  "zoom-out": __("Zoom Out"),
  "zoom-out-up": __("Zoom Out Up"),
  "zoom-out-down": __("Zoom Out Down"),
  "zoom-out-left": __("Zoom Out Left"),
  "zoom-out-right": __("Zoom Out Right")
};
const easingOptions = {
  "": __("Default"),
  linear: __("Linear"),
  ease: __("Ease"),
  "ease-in": __("Ease In"),
  "ease-out": __("Ease Out"),
  "ease-in-out": __("Ease In Out"),
  "ease-in-back": __("Ease In Back"),
  "ease-out-back": __("Ease Out Back"),
  "ease-in-out-back": __("Ease In Out Back"),
  "ease-in-sine": __("Ease In Sine"),
  "ease-out-sine": __("Ease Out Sine"),
  "ease-in-out-sine": __("Ease In Out Sine"),
  "ease-in-quad": __("Ease In Quad"),
  "ease-out-quad": __("Ease Out Quad"),
  "ease-in-out-quad": __("Ease In Out Quad"),
  "ease-in-cubic": __("Ease In Cubic"),
  "ease-out-cubic": __("Ease Out Cubic"),
  "ease-in-out-cubic": __("Ease In Out Cubic"),
  "ease-in-quart": __("Ease In Quart"),
  "ease-out-quart": __("Ease Out Quart"),
  "ease-in-out-quart": __("Ease In Out Quart")
};
const placements = {
  "": __("Default"),
  "top-bottom": __("Top Bottom"),
  "top-center": __("Top Center"),
  "top-top": __("Top Top"),
  "center-bottom": __("Center Bottom"),
  "center-center": __("Center Center"),
  "center-top": __("Center Top"),
  "bottom-bottom": __("Bottom Bottom"),
  "bottom-center": __("Bottom Center"),
  "bottom-top": __("Bottom Top")
};
addFilter(
  "blocks.registerBlockType",
  "rawa/add-animation-attributes",
  (settings, name) => {
    return {
      ...settings,
      attributes: {
        ...settings.attributes,
        rawaAnimationType: {
          type: "string",
          default: ""
        },
        rawaAnimationEasing: {
          type: "string",
          default: ""
        },
        rawaAnimationOffset: {
          type: "string",
          default: ""
        },
        rawaAnimationDuration: {
          type: "string",
          default: ""
        },
        rawaAnimationDelay: {
          type: "string",
          default: ""
        },
        rawaAnimationOnce: {
          type: "boolean",
          default: false
        }
      }
    };
  }
);
const withAnimationControls = createHigherOrderComponent((BlockEdit) => {
  return (props) => {
    const { attributes, setAttributes } = props;
    const {
      rawaAnimationType,
      rawaAnimationEasing,
      rawaAnimationOffset,
      rawaAnimationDuration,
      rawaAnimationDelay,
      rawaAnimationOnce
    } = attributes;
    return /* @__PURE__ */ React.createElement(React.Fragment, null, /* @__PURE__ */ React.createElement(BlockEdit, { ...props }), /* @__PURE__ */ React.createElement(InspectorControls, null, /* @__PURE__ */ React.createElement(PanelBody, { title: __("Animation"), initialOpen: false }, /* @__PURE__ */ React.createElement(
      SelectControl,
      {
        label: __("Animation Type"),
        value: rawaAnimationType,
        options: Object.entries(animations).map(([value, label]) => ({
          value,
          label
        })),
        onChange: (value) => setAttributes({ rawaAnimationType: value })
      }
    ), rawaAnimationType && /* @__PURE__ */ React.createElement(React.Fragment, null, /* @__PURE__ */ React.createElement(
      SelectControl,
      {
        label: __("Easing"),
        value: rawaAnimationEasing,
        options: Object.entries(easingOptions).map(
          ([value, label]) => ({
            value,
            label
          })
        ),
        onChange: (value) => setAttributes({ rawaAnimationEasing: value })
      }
    ), /* @__PURE__ */ React.createElement(
      TextControl,
      {
        label: __("Threshold"),
        value: rawaAnimationOffset,
        onChange: (value) => setAttributes({ rawaAnimationOffset: value }),
        help: __("Percentage of element visible to trigger (0-100)")
      }
    ), /* @__PURE__ */ React.createElement(
      TextControl,
      {
        label: __("Duration"),
        value: rawaAnimationDuration,
        onChange: (value) => setAttributes({ rawaAnimationDuration: value }),
        help: __("Animation duration in ms")
      }
    ), /* @__PURE__ */ React.createElement(
      TextControl,
      {
        label: __("Delay"),
        value: rawaAnimationDelay,
        onChange: (value) => setAttributes({ rawaAnimationDelay: value }),
        help: __("Animation delay in ms")
      }
    ), /* @__PURE__ */ React.createElement(
      ToggleControl,
      {
        label: __("Animate Once"),
        checked: rawaAnimationOnce,
        onChange: (value) => setAttributes({ rawaAnimationOnce: value }),
        help: __("Only animate once per page load")
      }
    )))));
  };
}, "withAnimationControls");
addFilter(
  "editor.BlockEdit",
  "rawa/with-animation-controls",
  withAnimationControls
);
addFilter(
  "blocks.getSaveElement",
  "rawa/add-animation-attributes-save",
  (element, blockType, attributes) => {
    if (!attributes.rawaAnimationType) {
      return element;
    }
    const usalParts = [];
    const animationMap = {
      fade: "fade",
      "fade-up": "fade-u",
      "fade-down": "fade-d",
      "fade-left": "fade-l",
      "fade-right": "fade-r",
      "fade-up-right": "fade-ur",
      "fade-up-left": "fade-ul",
      "fade-down-right": "fade-dr",
      "fade-down-left": "fade-dl",
      "flip-up": "flip-u",
      "flip-down": "flip-d",
      "flip-left": "flip-l",
      "flip-right": "flip-r",
      "slide-up": "slide-u",
      "slide-down": "slide-d",
      "slide-left": "slide-l",
      "slide-right": "slide-r",
      "zoom-in": "zoomin",
      "zoom-in-up": "zoomin-u",
      "zoom-in-down": "zoomin-d",
      "zoom-in-left": "zoomin-l",
      "zoom-in-right": "zoomin-r",
      "zoom-out": "zoomout",
      "zoom-out-up": "zoomout-u",
      "zoom-out-down": "zoomout-d",
      "zoom-out-left": "zoomout-l",
      "zoom-out-right": "zoomout-r"
    };
    if (attributes.rawaAnimationType) {
      const mappedAnimation = animationMap[attributes.rawaAnimationType] || attributes.rawaAnimationType;
      usalParts.push(mappedAnimation);
    }
    if (attributes.rawaAnimationDuration && attributes.rawaAnimationDuration !== "0") {
      usalParts.push(`duration-${parseInt(attributes.rawaAnimationDuration)}`);
    }
    if (attributes.rawaAnimationDelay) {
      usalParts.push(`delay-${parseInt(attributes.rawaAnimationDelay)}`);
    }
    if (attributes.rawaAnimationEasing) {
      usalParts.push(`easing-${attributes.rawaAnimationEasing}`);
    }
    if (attributes.rawaAnimationOnce) {
      usalParts.push("once");
    }
    if (usalParts.length > 0) {
      const dataUsal = usalParts.join(" ");
      if (element) {
        return {
          ...element,
          props: {
            ...element.props,
            "data-usal": dataUsal
          }
        };
      }
    }
    return element;
  }
);
