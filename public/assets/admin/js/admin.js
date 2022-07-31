/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@alpinejs/persist/dist/module.esm.js":
/*!***********************************************************!*\
  !*** ./node_modules/@alpinejs/persist/dist/module.esm.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ module_default)
/* harmony export */ });
// packages/persist/src/index.js
function src_default(Alpine) {
  let persist = () => {
    let alias;
    let storage = localStorage;
    return Alpine.interceptor((initialValue, getter, setter, path, key) => {
      let lookup = alias || `_x_${path}`;
      let initial = storageHas(lookup, storage) ? storageGet(lookup, storage) : initialValue;
      setter(initial);
      Alpine.effect(() => {
        let value = getter();
        storageSet(lookup, value, storage);
        setter(value);
      });
      return initial;
    }, (func) => {
      func.as = (key) => {
        alias = key;
        return func;
      }, func.using = (target) => {
        storage = target;
        return func;
      };
    });
  };
  Object.defineProperty(Alpine, "$persist", {get: () => persist()});
  Alpine.magic("persist", persist);
}
function storageHas(key, storage) {
  return storage.getItem(key) !== null;
}
function storageGet(key, storage) {
  return JSON.parse(storage.getItem(key, storage));
}
function storageSet(key, value, storage) {
  storage.setItem(key, JSON.stringify(value));
}

// packages/persist/builds/module.js
var module_default = src_default;



/***/ }),

/***/ "./node_modules/alpinejs/dist/module.esm.js":
/*!**************************************************!*\
  !*** ./node_modules/alpinejs/dist/module.esm.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ module_default)
/* harmony export */ });
var __create = Object.create;
var __defProp = Object.defineProperty;
var __getProtoOf = Object.getPrototypeOf;
var __hasOwnProp = Object.prototype.hasOwnProperty;
var __getOwnPropNames = Object.getOwnPropertyNames;
var __getOwnPropDesc = Object.getOwnPropertyDescriptor;
var __markAsModule = (target) => __defProp(target, "__esModule", {value: true});
var __commonJS = (callback, module) => () => {
  if (!module) {
    module = {exports: {}};
    callback(module.exports, module);
  }
  return module.exports;
};
var __exportStar = (target, module, desc) => {
  if (module && typeof module === "object" || typeof module === "function") {
    for (let key of __getOwnPropNames(module))
      if (!__hasOwnProp.call(target, key) && key !== "default")
        __defProp(target, key, {get: () => module[key], enumerable: !(desc = __getOwnPropDesc(module, key)) || desc.enumerable});
  }
  return target;
};
var __toModule = (module) => {
  return __exportStar(__markAsModule(__defProp(module != null ? __create(__getProtoOf(module)) : {}, "default", module && module.__esModule && "default" in module ? {get: () => module.default, enumerable: true} : {value: module, enumerable: true})), module);
};

// node_modules/@vue/shared/dist/shared.cjs.js
var require_shared_cjs = __commonJS((exports) => {
  "use strict";
  Object.defineProperty(exports, "__esModule", {value: true});
  function makeMap(str, expectsLowerCase) {
    const map = Object.create(null);
    const list = str.split(",");
    for (let i = 0; i < list.length; i++) {
      map[list[i]] = true;
    }
    return expectsLowerCase ? (val) => !!map[val.toLowerCase()] : (val) => !!map[val];
  }
  var PatchFlagNames = {
    [1]: `TEXT`,
    [2]: `CLASS`,
    [4]: `STYLE`,
    [8]: `PROPS`,
    [16]: `FULL_PROPS`,
    [32]: `HYDRATE_EVENTS`,
    [64]: `STABLE_FRAGMENT`,
    [128]: `KEYED_FRAGMENT`,
    [256]: `UNKEYED_FRAGMENT`,
    [512]: `NEED_PATCH`,
    [1024]: `DYNAMIC_SLOTS`,
    [2048]: `DEV_ROOT_FRAGMENT`,
    [-1]: `HOISTED`,
    [-2]: `BAIL`
  };
  var slotFlagsText = {
    [1]: "STABLE",
    [2]: "DYNAMIC",
    [3]: "FORWARDED"
  };
  var GLOBALS_WHITE_LISTED = "Infinity,undefined,NaN,isFinite,isNaN,parseFloat,parseInt,decodeURI,decodeURIComponent,encodeURI,encodeURIComponent,Math,Number,Date,Array,Object,Boolean,String,RegExp,Map,Set,JSON,Intl,BigInt";
  var isGloballyWhitelisted = /* @__PURE__ */ makeMap(GLOBALS_WHITE_LISTED);
  var range = 2;
  function generateCodeFrame(source, start2 = 0, end = source.length) {
    const lines = source.split(/\r?\n/);
    let count = 0;
    const res = [];
    for (let i = 0; i < lines.length; i++) {
      count += lines[i].length + 1;
      if (count >= start2) {
        for (let j = i - range; j <= i + range || end > count; j++) {
          if (j < 0 || j >= lines.length)
            continue;
          const line = j + 1;
          res.push(`${line}${" ".repeat(Math.max(3 - String(line).length, 0))}|  ${lines[j]}`);
          const lineLength = lines[j].length;
          if (j === i) {
            const pad = start2 - (count - lineLength) + 1;
            const length = Math.max(1, end > count ? lineLength - pad : end - start2);
            res.push(`   |  ` + " ".repeat(pad) + "^".repeat(length));
          } else if (j > i) {
            if (end > count) {
              const length = Math.max(Math.min(end - count, lineLength), 1);
              res.push(`   |  ` + "^".repeat(length));
            }
            count += lineLength + 1;
          }
        }
        break;
      }
    }
    return res.join("\n");
  }
  var specialBooleanAttrs = `itemscope,allowfullscreen,formnovalidate,ismap,nomodule,novalidate,readonly`;
  var isSpecialBooleanAttr = /* @__PURE__ */ makeMap(specialBooleanAttrs);
  var isBooleanAttr2 = /* @__PURE__ */ makeMap(specialBooleanAttrs + `,async,autofocus,autoplay,controls,default,defer,disabled,hidden,loop,open,required,reversed,scoped,seamless,checked,muted,multiple,selected`);
  var unsafeAttrCharRE = /[>/="'\u0009\u000a\u000c\u0020]/;
  var attrValidationCache = {};
  function isSSRSafeAttrName(name) {
    if (attrValidationCache.hasOwnProperty(name)) {
      return attrValidationCache[name];
    }
    const isUnsafe = unsafeAttrCharRE.test(name);
    if (isUnsafe) {
      console.error(`unsafe attribute name: ${name}`);
    }
    return attrValidationCache[name] = !isUnsafe;
  }
  var propsToAttrMap = {
    acceptCharset: "accept-charset",
    className: "class",
    htmlFor: "for",
    httpEquiv: "http-equiv"
  };
  var isNoUnitNumericStyleProp = /* @__PURE__ */ makeMap(`animation-iteration-count,border-image-outset,border-image-slice,border-image-width,box-flex,box-flex-group,box-ordinal-group,column-count,columns,flex,flex-grow,flex-positive,flex-shrink,flex-negative,flex-order,grid-row,grid-row-end,grid-row-span,grid-row-start,grid-column,grid-column-end,grid-column-span,grid-column-start,font-weight,line-clamp,line-height,opacity,order,orphans,tab-size,widows,z-index,zoom,fill-opacity,flood-opacity,stop-opacity,stroke-dasharray,stroke-dashoffset,stroke-miterlimit,stroke-opacity,stroke-width`);
  var isKnownAttr = /* @__PURE__ */ makeMap(`accept,accept-charset,accesskey,action,align,allow,alt,async,autocapitalize,autocomplete,autofocus,autoplay,background,bgcolor,border,buffered,capture,challenge,charset,checked,cite,class,code,codebase,color,cols,colspan,content,contenteditable,contextmenu,controls,coords,crossorigin,csp,data,datetime,decoding,default,defer,dir,dirname,disabled,download,draggable,dropzone,enctype,enterkeyhint,for,form,formaction,formenctype,formmethod,formnovalidate,formtarget,headers,height,hidden,high,href,hreflang,http-equiv,icon,id,importance,integrity,ismap,itemprop,keytype,kind,label,lang,language,loading,list,loop,low,manifest,max,maxlength,minlength,media,min,multiple,muted,name,novalidate,open,optimum,pattern,ping,placeholder,poster,preload,radiogroup,readonly,referrerpolicy,rel,required,reversed,rows,rowspan,sandbox,scope,scoped,selected,shape,size,sizes,slot,span,spellcheck,src,srcdoc,srclang,srcset,start,step,style,summary,tabindex,target,title,translate,type,usemap,value,width,wrap`);
  function normalizeStyle(value) {
    if (isArray(value)) {
      const res = {};
      for (let i = 0; i < value.length; i++) {
        const item = value[i];
        const normalized = normalizeStyle(isString(item) ? parseStringStyle(item) : item);
        if (normalized) {
          for (const key in normalized) {
            res[key] = normalized[key];
          }
        }
      }
      return res;
    } else if (isObject(value)) {
      return value;
    }
  }
  var listDelimiterRE = /;(?![^(]*\))/g;
  var propertyDelimiterRE = /:(.+)/;
  function parseStringStyle(cssText) {
    const ret = {};
    cssText.split(listDelimiterRE).forEach((item) => {
      if (item) {
        const tmp = item.split(propertyDelimiterRE);
        tmp.length > 1 && (ret[tmp[0].trim()] = tmp[1].trim());
      }
    });
    return ret;
  }
  function stringifyStyle(styles) {
    let ret = "";
    if (!styles) {
      return ret;
    }
    for (const key in styles) {
      const value = styles[key];
      const normalizedKey = key.startsWith(`--`) ? key : hyphenate(key);
      if (isString(value) || typeof value === "number" && isNoUnitNumericStyleProp(normalizedKey)) {
        ret += `${normalizedKey}:${value};`;
      }
    }
    return ret;
  }
  function normalizeClass(value) {
    let res = "";
    if (isString(value)) {
      res = value;
    } else if (isArray(value)) {
      for (let i = 0; i < value.length; i++) {
        const normalized = normalizeClass(value[i]);
        if (normalized) {
          res += normalized + " ";
        }
      }
    } else if (isObject(value)) {
      for (const name in value) {
        if (value[name]) {
          res += name + " ";
        }
      }
    }
    return res.trim();
  }
  var HTML_TAGS = "html,body,base,head,link,meta,style,title,address,article,aside,footer,header,h1,h2,h3,h4,h5,h6,hgroup,nav,section,div,dd,dl,dt,figcaption,figure,picture,hr,img,li,main,ol,p,pre,ul,a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,rtc,ruby,s,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,embed,object,param,source,canvas,script,noscript,del,ins,caption,col,colgroup,table,thead,tbody,td,th,tr,button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,output,progress,select,textarea,details,dialog,menu,summary,template,blockquote,iframe,tfoot";
  var SVG_TAGS = "svg,animate,animateMotion,animateTransform,circle,clipPath,color-profile,defs,desc,discard,ellipse,feBlend,feColorMatrix,feComponentTransfer,feComposite,feConvolveMatrix,feDiffuseLighting,feDisplacementMap,feDistanceLight,feDropShadow,feFlood,feFuncA,feFuncB,feFuncG,feFuncR,feGaussianBlur,feImage,feMerge,feMergeNode,feMorphology,feOffset,fePointLight,feSpecularLighting,feSpotLight,feTile,feTurbulence,filter,foreignObject,g,hatch,hatchpath,image,line,linearGradient,marker,mask,mesh,meshgradient,meshpatch,meshrow,metadata,mpath,path,pattern,polygon,polyline,radialGradient,rect,set,solidcolor,stop,switch,symbol,text,textPath,title,tspan,unknown,use,view";
  var VOID_TAGS = "area,base,br,col,embed,hr,img,input,link,meta,param,source,track,wbr";
  var isHTMLTag = /* @__PURE__ */ makeMap(HTML_TAGS);
  var isSVGTag = /* @__PURE__ */ makeMap(SVG_TAGS);
  var isVoidTag = /* @__PURE__ */ makeMap(VOID_TAGS);
  var escapeRE = /["'&<>]/;
  function escapeHtml(string) {
    const str = "" + string;
    const match = escapeRE.exec(str);
    if (!match) {
      return str;
    }
    let html = "";
    let escaped;
    let index;
    let lastIndex = 0;
    for (index = match.index; index < str.length; index++) {
      switch (str.charCodeAt(index)) {
        case 34:
          escaped = "&quot;";
          break;
        case 38:
          escaped = "&amp;";
          break;
        case 39:
          escaped = "&#39;";
          break;
        case 60:
          escaped = "&lt;";
          break;
        case 62:
          escaped = "&gt;";
          break;
        default:
          continue;
      }
      if (lastIndex !== index) {
        html += str.substring(lastIndex, index);
      }
      lastIndex = index + 1;
      html += escaped;
    }
    return lastIndex !== index ? html + str.substring(lastIndex, index) : html;
  }
  var commentStripRE = /^-?>|<!--|-->|--!>|<!-$/g;
  function escapeHtmlComment(src) {
    return src.replace(commentStripRE, "");
  }
  function looseCompareArrays(a, b) {
    if (a.length !== b.length)
      return false;
    let equal = true;
    for (let i = 0; equal && i < a.length; i++) {
      equal = looseEqual(a[i], b[i]);
    }
    return equal;
  }
  function looseEqual(a, b) {
    if (a === b)
      return true;
    let aValidType = isDate(a);
    let bValidType = isDate(b);
    if (aValidType || bValidType) {
      return aValidType && bValidType ? a.getTime() === b.getTime() : false;
    }
    aValidType = isArray(a);
    bValidType = isArray(b);
    if (aValidType || bValidType) {
      return aValidType && bValidType ? looseCompareArrays(a, b) : false;
    }
    aValidType = isObject(a);
    bValidType = isObject(b);
    if (aValidType || bValidType) {
      if (!aValidType || !bValidType) {
        return false;
      }
      const aKeysCount = Object.keys(a).length;
      const bKeysCount = Object.keys(b).length;
      if (aKeysCount !== bKeysCount) {
        return false;
      }
      for (const key in a) {
        const aHasKey = a.hasOwnProperty(key);
        const bHasKey = b.hasOwnProperty(key);
        if (aHasKey && !bHasKey || !aHasKey && bHasKey || !looseEqual(a[key], b[key])) {
          return false;
        }
      }
    }
    return String(a) === String(b);
  }
  function looseIndexOf(arr, val) {
    return arr.findIndex((item) => looseEqual(item, val));
  }
  var toDisplayString = (val) => {
    return val == null ? "" : isObject(val) ? JSON.stringify(val, replacer, 2) : String(val);
  };
  var replacer = (_key, val) => {
    if (isMap(val)) {
      return {
        [`Map(${val.size})`]: [...val.entries()].reduce((entries, [key, val2]) => {
          entries[`${key} =>`] = val2;
          return entries;
        }, {})
      };
    } else if (isSet(val)) {
      return {
        [`Set(${val.size})`]: [...val.values()]
      };
    } else if (isObject(val) && !isArray(val) && !isPlainObject(val)) {
      return String(val);
    }
    return val;
  };
  var babelParserDefaultPlugins = [
    "bigInt",
    "optionalChaining",
    "nullishCoalescingOperator"
  ];
  var EMPTY_OBJ = Object.freeze({});
  var EMPTY_ARR = Object.freeze([]);
  var NOOP = () => {
  };
  var NO = () => false;
  var onRE = /^on[^a-z]/;
  var isOn = (key) => onRE.test(key);
  var isModelListener = (key) => key.startsWith("onUpdate:");
  var extend = Object.assign;
  var remove = (arr, el) => {
    const i = arr.indexOf(el);
    if (i > -1) {
      arr.splice(i, 1);
    }
  };
  var hasOwnProperty = Object.prototype.hasOwnProperty;
  var hasOwn = (val, key) => hasOwnProperty.call(val, key);
  var isArray = Array.isArray;
  var isMap = (val) => toTypeString(val) === "[object Map]";
  var isSet = (val) => toTypeString(val) === "[object Set]";
  var isDate = (val) => val instanceof Date;
  var isFunction = (val) => typeof val === "function";
  var isString = (val) => typeof val === "string";
  var isSymbol = (val) => typeof val === "symbol";
  var isObject = (val) => val !== null && typeof val === "object";
  var isPromise = (val) => {
    return isObject(val) && isFunction(val.then) && isFunction(val.catch);
  };
  var objectToString = Object.prototype.toString;
  var toTypeString = (value) => objectToString.call(value);
  var toRawType = (value) => {
    return toTypeString(value).slice(8, -1);
  };
  var isPlainObject = (val) => toTypeString(val) === "[object Object]";
  var isIntegerKey = (key) => isString(key) && key !== "NaN" && key[0] !== "-" && "" + parseInt(key, 10) === key;
  var isReservedProp = /* @__PURE__ */ makeMap(",key,ref,onVnodeBeforeMount,onVnodeMounted,onVnodeBeforeUpdate,onVnodeUpdated,onVnodeBeforeUnmount,onVnodeUnmounted");
  var cacheStringFunction = (fn) => {
    const cache = Object.create(null);
    return (str) => {
      const hit = cache[str];
      return hit || (cache[str] = fn(str));
    };
  };
  var camelizeRE = /-(\w)/g;
  var camelize = cacheStringFunction((str) => {
    return str.replace(camelizeRE, (_, c) => c ? c.toUpperCase() : "");
  });
  var hyphenateRE = /\B([A-Z])/g;
  var hyphenate = cacheStringFunction((str) => str.replace(hyphenateRE, "-$1").toLowerCase());
  var capitalize = cacheStringFunction((str) => str.charAt(0).toUpperCase() + str.slice(1));
  var toHandlerKey = cacheStringFunction((str) => str ? `on${capitalize(str)}` : ``);
  var hasChanged = (value, oldValue) => value !== oldValue && (value === value || oldValue === oldValue);
  var invokeArrayFns = (fns, arg) => {
    for (let i = 0; i < fns.length; i++) {
      fns[i](arg);
    }
  };
  var def = (obj, key, value) => {
    Object.defineProperty(obj, key, {
      configurable: true,
      enumerable: false,
      value
    });
  };
  var toNumber = (val) => {
    const n = parseFloat(val);
    return isNaN(n) ? val : n;
  };
  var _globalThis;
  var getGlobalThis = () => {
    return _globalThis || (_globalThis = typeof globalThis !== "undefined" ? globalThis : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof __webpack_require__.g !== "undefined" ? __webpack_require__.g : {});
  };
  exports.EMPTY_ARR = EMPTY_ARR;
  exports.EMPTY_OBJ = EMPTY_OBJ;
  exports.NO = NO;
  exports.NOOP = NOOP;
  exports.PatchFlagNames = PatchFlagNames;
  exports.babelParserDefaultPlugins = babelParserDefaultPlugins;
  exports.camelize = camelize;
  exports.capitalize = capitalize;
  exports.def = def;
  exports.escapeHtml = escapeHtml;
  exports.escapeHtmlComment = escapeHtmlComment;
  exports.extend = extend;
  exports.generateCodeFrame = generateCodeFrame;
  exports.getGlobalThis = getGlobalThis;
  exports.hasChanged = hasChanged;
  exports.hasOwn = hasOwn;
  exports.hyphenate = hyphenate;
  exports.invokeArrayFns = invokeArrayFns;
  exports.isArray = isArray;
  exports.isBooleanAttr = isBooleanAttr2;
  exports.isDate = isDate;
  exports.isFunction = isFunction;
  exports.isGloballyWhitelisted = isGloballyWhitelisted;
  exports.isHTMLTag = isHTMLTag;
  exports.isIntegerKey = isIntegerKey;
  exports.isKnownAttr = isKnownAttr;
  exports.isMap = isMap;
  exports.isModelListener = isModelListener;
  exports.isNoUnitNumericStyleProp = isNoUnitNumericStyleProp;
  exports.isObject = isObject;
  exports.isOn = isOn;
  exports.isPlainObject = isPlainObject;
  exports.isPromise = isPromise;
  exports.isReservedProp = isReservedProp;
  exports.isSSRSafeAttrName = isSSRSafeAttrName;
  exports.isSVGTag = isSVGTag;
  exports.isSet = isSet;
  exports.isSpecialBooleanAttr = isSpecialBooleanAttr;
  exports.isString = isString;
  exports.isSymbol = isSymbol;
  exports.isVoidTag = isVoidTag;
  exports.looseEqual = looseEqual;
  exports.looseIndexOf = looseIndexOf;
  exports.makeMap = makeMap;
  exports.normalizeClass = normalizeClass;
  exports.normalizeStyle = normalizeStyle;
  exports.objectToString = objectToString;
  exports.parseStringStyle = parseStringStyle;
  exports.propsToAttrMap = propsToAttrMap;
  exports.remove = remove;
  exports.slotFlagsText = slotFlagsText;
  exports.stringifyStyle = stringifyStyle;
  exports.toDisplayString = toDisplayString;
  exports.toHandlerKey = toHandlerKey;
  exports.toNumber = toNumber;
  exports.toRawType = toRawType;
  exports.toTypeString = toTypeString;
});

// node_modules/@vue/shared/index.js
var require_shared = __commonJS((exports, module) => {
  "use strict";
  if (false) {} else {
    module.exports = require_shared_cjs();
  }
});

// node_modules/@vue/reactivity/dist/reactivity.cjs.js
var require_reactivity_cjs = __commonJS((exports) => {
  "use strict";
  Object.defineProperty(exports, "__esModule", {value: true});
  var shared = require_shared();
  var targetMap = new WeakMap();
  var effectStack = [];
  var activeEffect;
  var ITERATE_KEY = Symbol("iterate");
  var MAP_KEY_ITERATE_KEY = Symbol("Map key iterate");
  function isEffect(fn) {
    return fn && fn._isEffect === true;
  }
  function effect3(fn, options = shared.EMPTY_OBJ) {
    if (isEffect(fn)) {
      fn = fn.raw;
    }
    const effect4 = createReactiveEffect(fn, options);
    if (!options.lazy) {
      effect4();
    }
    return effect4;
  }
  function stop2(effect4) {
    if (effect4.active) {
      cleanup(effect4);
      if (effect4.options.onStop) {
        effect4.options.onStop();
      }
      effect4.active = false;
    }
  }
  var uid = 0;
  function createReactiveEffect(fn, options) {
    const effect4 = function reactiveEffect() {
      if (!effect4.active) {
        return fn();
      }
      if (!effectStack.includes(effect4)) {
        cleanup(effect4);
        try {
          enableTracking();
          effectStack.push(effect4);
          activeEffect = effect4;
          return fn();
        } finally {
          effectStack.pop();
          resetTracking();
          activeEffect = effectStack[effectStack.length - 1];
        }
      }
    };
    effect4.id = uid++;
    effect4.allowRecurse = !!options.allowRecurse;
    effect4._isEffect = true;
    effect4.active = true;
    effect4.raw = fn;
    effect4.deps = [];
    effect4.options = options;
    return effect4;
  }
  function cleanup(effect4) {
    const {deps} = effect4;
    if (deps.length) {
      for (let i = 0; i < deps.length; i++) {
        deps[i].delete(effect4);
      }
      deps.length = 0;
    }
  }
  var shouldTrack = true;
  var trackStack = [];
  function pauseTracking() {
    trackStack.push(shouldTrack);
    shouldTrack = false;
  }
  function enableTracking() {
    trackStack.push(shouldTrack);
    shouldTrack = true;
  }
  function resetTracking() {
    const last = trackStack.pop();
    shouldTrack = last === void 0 ? true : last;
  }
  function track(target, type, key) {
    if (!shouldTrack || activeEffect === void 0) {
      return;
    }
    let depsMap = targetMap.get(target);
    if (!depsMap) {
      targetMap.set(target, depsMap = new Map());
    }
    let dep = depsMap.get(key);
    if (!dep) {
      depsMap.set(key, dep = new Set());
    }
    if (!dep.has(activeEffect)) {
      dep.add(activeEffect);
      activeEffect.deps.push(dep);
      if (activeEffect.options.onTrack) {
        activeEffect.options.onTrack({
          effect: activeEffect,
          target,
          type,
          key
        });
      }
    }
  }
  function trigger(target, type, key, newValue, oldValue, oldTarget) {
    const depsMap = targetMap.get(target);
    if (!depsMap) {
      return;
    }
    const effects = new Set();
    const add2 = (effectsToAdd) => {
      if (effectsToAdd) {
        effectsToAdd.forEach((effect4) => {
          if (effect4 !== activeEffect || effect4.allowRecurse) {
            effects.add(effect4);
          }
        });
      }
    };
    if (type === "clear") {
      depsMap.forEach(add2);
    } else if (key === "length" && shared.isArray(target)) {
      depsMap.forEach((dep, key2) => {
        if (key2 === "length" || key2 >= newValue) {
          add2(dep);
        }
      });
    } else {
      if (key !== void 0) {
        add2(depsMap.get(key));
      }
      switch (type) {
        case "add":
          if (!shared.isArray(target)) {
            add2(depsMap.get(ITERATE_KEY));
            if (shared.isMap(target)) {
              add2(depsMap.get(MAP_KEY_ITERATE_KEY));
            }
          } else if (shared.isIntegerKey(key)) {
            add2(depsMap.get("length"));
          }
          break;
        case "delete":
          if (!shared.isArray(target)) {
            add2(depsMap.get(ITERATE_KEY));
            if (shared.isMap(target)) {
              add2(depsMap.get(MAP_KEY_ITERATE_KEY));
            }
          }
          break;
        case "set":
          if (shared.isMap(target)) {
            add2(depsMap.get(ITERATE_KEY));
          }
          break;
      }
    }
    const run = (effect4) => {
      if (effect4.options.onTrigger) {
        effect4.options.onTrigger({
          effect: effect4,
          target,
          key,
          type,
          newValue,
          oldValue,
          oldTarget
        });
      }
      if (effect4.options.scheduler) {
        effect4.options.scheduler(effect4);
      } else {
        effect4();
      }
    };
    effects.forEach(run);
  }
  var isNonTrackableKeys = /* @__PURE__ */ shared.makeMap(`__proto__,__v_isRef,__isVue`);
  var builtInSymbols = new Set(Object.getOwnPropertyNames(Symbol).map((key) => Symbol[key]).filter(shared.isSymbol));
  var get2 = /* @__PURE__ */ createGetter();
  var shallowGet = /* @__PURE__ */ createGetter(false, true);
  var readonlyGet = /* @__PURE__ */ createGetter(true);
  var shallowReadonlyGet = /* @__PURE__ */ createGetter(true, true);
  var arrayInstrumentations = {};
  ["includes", "indexOf", "lastIndexOf"].forEach((key) => {
    const method = Array.prototype[key];
    arrayInstrumentations[key] = function(...args) {
      const arr = toRaw2(this);
      for (let i = 0, l = this.length; i < l; i++) {
        track(arr, "get", i + "");
      }
      const res = method.apply(arr, args);
      if (res === -1 || res === false) {
        return method.apply(arr, args.map(toRaw2));
      } else {
        return res;
      }
    };
  });
  ["push", "pop", "shift", "unshift", "splice"].forEach((key) => {
    const method = Array.prototype[key];
    arrayInstrumentations[key] = function(...args) {
      pauseTracking();
      const res = method.apply(this, args);
      resetTracking();
      return res;
    };
  });
  function createGetter(isReadonly2 = false, shallow = false) {
    return function get3(target, key, receiver) {
      if (key === "__v_isReactive") {
        return !isReadonly2;
      } else if (key === "__v_isReadonly") {
        return isReadonly2;
      } else if (key === "__v_raw" && receiver === (isReadonly2 ? shallow ? shallowReadonlyMap : readonlyMap : shallow ? shallowReactiveMap : reactiveMap).get(target)) {
        return target;
      }
      const targetIsArray = shared.isArray(target);
      if (!isReadonly2 && targetIsArray && shared.hasOwn(arrayInstrumentations, key)) {
        return Reflect.get(arrayInstrumentations, key, receiver);
      }
      const res = Reflect.get(target, key, receiver);
      if (shared.isSymbol(key) ? builtInSymbols.has(key) : isNonTrackableKeys(key)) {
        return res;
      }
      if (!isReadonly2) {
        track(target, "get", key);
      }
      if (shallow) {
        return res;
      }
      if (isRef(res)) {
        const shouldUnwrap = !targetIsArray || !shared.isIntegerKey(key);
        return shouldUnwrap ? res.value : res;
      }
      if (shared.isObject(res)) {
        return isReadonly2 ? readonly(res) : reactive3(res);
      }
      return res;
    };
  }
  var set2 = /* @__PURE__ */ createSetter();
  var shallowSet = /* @__PURE__ */ createSetter(true);
  function createSetter(shallow = false) {
    return function set3(target, key, value, receiver) {
      let oldValue = target[key];
      if (!shallow) {
        value = toRaw2(value);
        oldValue = toRaw2(oldValue);
        if (!shared.isArray(target) && isRef(oldValue) && !isRef(value)) {
          oldValue.value = value;
          return true;
        }
      }
      const hadKey = shared.isArray(target) && shared.isIntegerKey(key) ? Number(key) < target.length : shared.hasOwn(target, key);
      const result = Reflect.set(target, key, value, receiver);
      if (target === toRaw2(receiver)) {
        if (!hadKey) {
          trigger(target, "add", key, value);
        } else if (shared.hasChanged(value, oldValue)) {
          trigger(target, "set", key, value, oldValue);
        }
      }
      return result;
    };
  }
  function deleteProperty(target, key) {
    const hadKey = shared.hasOwn(target, key);
    const oldValue = target[key];
    const result = Reflect.deleteProperty(target, key);
    if (result && hadKey) {
      trigger(target, "delete", key, void 0, oldValue);
    }
    return result;
  }
  function has(target, key) {
    const result = Reflect.has(target, key);
    if (!shared.isSymbol(key) || !builtInSymbols.has(key)) {
      track(target, "has", key);
    }
    return result;
  }
  function ownKeys(target) {
    track(target, "iterate", shared.isArray(target) ? "length" : ITERATE_KEY);
    return Reflect.ownKeys(target);
  }
  var mutableHandlers = {
    get: get2,
    set: set2,
    deleteProperty,
    has,
    ownKeys
  };
  var readonlyHandlers = {
    get: readonlyGet,
    set(target, key) {
      {
        console.warn(`Set operation on key "${String(key)}" failed: target is readonly.`, target);
      }
      return true;
    },
    deleteProperty(target, key) {
      {
        console.warn(`Delete operation on key "${String(key)}" failed: target is readonly.`, target);
      }
      return true;
    }
  };
  var shallowReactiveHandlers = shared.extend({}, mutableHandlers, {
    get: shallowGet,
    set: shallowSet
  });
  var shallowReadonlyHandlers = shared.extend({}, readonlyHandlers, {
    get: shallowReadonlyGet
  });
  var toReactive = (value) => shared.isObject(value) ? reactive3(value) : value;
  var toReadonly = (value) => shared.isObject(value) ? readonly(value) : value;
  var toShallow = (value) => value;
  var getProto = (v) => Reflect.getPrototypeOf(v);
  function get$1(target, key, isReadonly2 = false, isShallow = false) {
    target = target["__v_raw"];
    const rawTarget = toRaw2(target);
    const rawKey = toRaw2(key);
    if (key !== rawKey) {
      !isReadonly2 && track(rawTarget, "get", key);
    }
    !isReadonly2 && track(rawTarget, "get", rawKey);
    const {has: has2} = getProto(rawTarget);
    const wrap = isShallow ? toShallow : isReadonly2 ? toReadonly : toReactive;
    if (has2.call(rawTarget, key)) {
      return wrap(target.get(key));
    } else if (has2.call(rawTarget, rawKey)) {
      return wrap(target.get(rawKey));
    } else if (target !== rawTarget) {
      target.get(key);
    }
  }
  function has$1(key, isReadonly2 = false) {
    const target = this["__v_raw"];
    const rawTarget = toRaw2(target);
    const rawKey = toRaw2(key);
    if (key !== rawKey) {
      !isReadonly2 && track(rawTarget, "has", key);
    }
    !isReadonly2 && track(rawTarget, "has", rawKey);
    return key === rawKey ? target.has(key) : target.has(key) || target.has(rawKey);
  }
  function size(target, isReadonly2 = false) {
    target = target["__v_raw"];
    !isReadonly2 && track(toRaw2(target), "iterate", ITERATE_KEY);
    return Reflect.get(target, "size", target);
  }
  function add(value) {
    value = toRaw2(value);
    const target = toRaw2(this);
    const proto = getProto(target);
    const hadKey = proto.has.call(target, value);
    if (!hadKey) {
      target.add(value);
      trigger(target, "add", value, value);
    }
    return this;
  }
  function set$1(key, value) {
    value = toRaw2(value);
    const target = toRaw2(this);
    const {has: has2, get: get3} = getProto(target);
    let hadKey = has2.call(target, key);
    if (!hadKey) {
      key = toRaw2(key);
      hadKey = has2.call(target, key);
    } else {
      checkIdentityKeys(target, has2, key);
    }
    const oldValue = get3.call(target, key);
    target.set(key, value);
    if (!hadKey) {
      trigger(target, "add", key, value);
    } else if (shared.hasChanged(value, oldValue)) {
      trigger(target, "set", key, value, oldValue);
    }
    return this;
  }
  function deleteEntry(key) {
    const target = toRaw2(this);
    const {has: has2, get: get3} = getProto(target);
    let hadKey = has2.call(target, key);
    if (!hadKey) {
      key = toRaw2(key);
      hadKey = has2.call(target, key);
    } else {
      checkIdentityKeys(target, has2, key);
    }
    const oldValue = get3 ? get3.call(target, key) : void 0;
    const result = target.delete(key);
    if (hadKey) {
      trigger(target, "delete", key, void 0, oldValue);
    }
    return result;
  }
  function clear() {
    const target = toRaw2(this);
    const hadItems = target.size !== 0;
    const oldTarget = shared.isMap(target) ? new Map(target) : new Set(target);
    const result = target.clear();
    if (hadItems) {
      trigger(target, "clear", void 0, void 0, oldTarget);
    }
    return result;
  }
  function createForEach(isReadonly2, isShallow) {
    return function forEach(callback, thisArg) {
      const observed = this;
      const target = observed["__v_raw"];
      const rawTarget = toRaw2(target);
      const wrap = isShallow ? toShallow : isReadonly2 ? toReadonly : toReactive;
      !isReadonly2 && track(rawTarget, "iterate", ITERATE_KEY);
      return target.forEach((value, key) => {
        return callback.call(thisArg, wrap(value), wrap(key), observed);
      });
    };
  }
  function createIterableMethod(method, isReadonly2, isShallow) {
    return function(...args) {
      const target = this["__v_raw"];
      const rawTarget = toRaw2(target);
      const targetIsMap = shared.isMap(rawTarget);
      const isPair = method === "entries" || method === Symbol.iterator && targetIsMap;
      const isKeyOnly = method === "keys" && targetIsMap;
      const innerIterator = target[method](...args);
      const wrap = isShallow ? toShallow : isReadonly2 ? toReadonly : toReactive;
      !isReadonly2 && track(rawTarget, "iterate", isKeyOnly ? MAP_KEY_ITERATE_KEY : ITERATE_KEY);
      return {
        next() {
          const {value, done} = innerIterator.next();
          return done ? {value, done} : {
            value: isPair ? [wrap(value[0]), wrap(value[1])] : wrap(value),
            done
          };
        },
        [Symbol.iterator]() {
          return this;
        }
      };
    };
  }
  function createReadonlyMethod(type) {
    return function(...args) {
      {
        const key = args[0] ? `on key "${args[0]}" ` : ``;
        console.warn(`${shared.capitalize(type)} operation ${key}failed: target is readonly.`, toRaw2(this));
      }
      return type === "delete" ? false : this;
    };
  }
  var mutableInstrumentations = {
    get(key) {
      return get$1(this, key);
    },
    get size() {
      return size(this);
    },
    has: has$1,
    add,
    set: set$1,
    delete: deleteEntry,
    clear,
    forEach: createForEach(false, false)
  };
  var shallowInstrumentations = {
    get(key) {
      return get$1(this, key, false, true);
    },
    get size() {
      return size(this);
    },
    has: has$1,
    add,
    set: set$1,
    delete: deleteEntry,
    clear,
    forEach: createForEach(false, true)
  };
  var readonlyInstrumentations = {
    get(key) {
      return get$1(this, key, true);
    },
    get size() {
      return size(this, true);
    },
    has(key) {
      return has$1.call(this, key, true);
    },
    add: createReadonlyMethod("add"),
    set: createReadonlyMethod("set"),
    delete: createReadonlyMethod("delete"),
    clear: createReadonlyMethod("clear"),
    forEach: createForEach(true, false)
  };
  var shallowReadonlyInstrumentations = {
    get(key) {
      return get$1(this, key, true, true);
    },
    get size() {
      return size(this, true);
    },
    has(key) {
      return has$1.call(this, key, true);
    },
    add: createReadonlyMethod("add"),
    set: createReadonlyMethod("set"),
    delete: createReadonlyMethod("delete"),
    clear: createReadonlyMethod("clear"),
    forEach: createForEach(true, true)
  };
  var iteratorMethods = ["keys", "values", "entries", Symbol.iterator];
  iteratorMethods.forEach((method) => {
    mutableInstrumentations[method] = createIterableMethod(method, false, false);
    readonlyInstrumentations[method] = createIterableMethod(method, true, false);
    shallowInstrumentations[method] = createIterableMethod(method, false, true);
    shallowReadonlyInstrumentations[method] = createIterableMethod(method, true, true);
  });
  function createInstrumentationGetter(isReadonly2, shallow) {
    const instrumentations = shallow ? isReadonly2 ? shallowReadonlyInstrumentations : shallowInstrumentations : isReadonly2 ? readonlyInstrumentations : mutableInstrumentations;
    return (target, key, receiver) => {
      if (key === "__v_isReactive") {
        return !isReadonly2;
      } else if (key === "__v_isReadonly") {
        return isReadonly2;
      } else if (key === "__v_raw") {
        return target;
      }
      return Reflect.get(shared.hasOwn(instrumentations, key) && key in target ? instrumentations : target, key, receiver);
    };
  }
  var mutableCollectionHandlers = {
    get: createInstrumentationGetter(false, false)
  };
  var shallowCollectionHandlers = {
    get: createInstrumentationGetter(false, true)
  };
  var readonlyCollectionHandlers = {
    get: createInstrumentationGetter(true, false)
  };
  var shallowReadonlyCollectionHandlers = {
    get: createInstrumentationGetter(true, true)
  };
  function checkIdentityKeys(target, has2, key) {
    const rawKey = toRaw2(key);
    if (rawKey !== key && has2.call(target, rawKey)) {
      const type = shared.toRawType(target);
      console.warn(`Reactive ${type} contains both the raw and reactive versions of the same object${type === `Map` ? ` as keys` : ``}, which can lead to inconsistencies. Avoid differentiating between the raw and reactive versions of an object and only use the reactive version if possible.`);
    }
  }
  var reactiveMap = new WeakMap();
  var shallowReactiveMap = new WeakMap();
  var readonlyMap = new WeakMap();
  var shallowReadonlyMap = new WeakMap();
  function targetTypeMap(rawType) {
    switch (rawType) {
      case "Object":
      case "Array":
        return 1;
      case "Map":
      case "Set":
      case "WeakMap":
      case "WeakSet":
        return 2;
      default:
        return 0;
    }
  }
  function getTargetType(value) {
    return value["__v_skip"] || !Object.isExtensible(value) ? 0 : targetTypeMap(shared.toRawType(value));
  }
  function reactive3(target) {
    if (target && target["__v_isReadonly"]) {
      return target;
    }
    return createReactiveObject(target, false, mutableHandlers, mutableCollectionHandlers, reactiveMap);
  }
  function shallowReactive(target) {
    return createReactiveObject(target, false, shallowReactiveHandlers, shallowCollectionHandlers, shallowReactiveMap);
  }
  function readonly(target) {
    return createReactiveObject(target, true, readonlyHandlers, readonlyCollectionHandlers, readonlyMap);
  }
  function shallowReadonly(target) {
    return createReactiveObject(target, true, shallowReadonlyHandlers, shallowReadonlyCollectionHandlers, shallowReadonlyMap);
  }
  function createReactiveObject(target, isReadonly2, baseHandlers, collectionHandlers, proxyMap) {
    if (!shared.isObject(target)) {
      {
        console.warn(`value cannot be made reactive: ${String(target)}`);
      }
      return target;
    }
    if (target["__v_raw"] && !(isReadonly2 && target["__v_isReactive"])) {
      return target;
    }
    const existingProxy = proxyMap.get(target);
    if (existingProxy) {
      return existingProxy;
    }
    const targetType = getTargetType(target);
    if (targetType === 0) {
      return target;
    }
    const proxy = new Proxy(target, targetType === 2 ? collectionHandlers : baseHandlers);
    proxyMap.set(target, proxy);
    return proxy;
  }
  function isReactive2(value) {
    if (isReadonly(value)) {
      return isReactive2(value["__v_raw"]);
    }
    return !!(value && value["__v_isReactive"]);
  }
  function isReadonly(value) {
    return !!(value && value["__v_isReadonly"]);
  }
  function isProxy(value) {
    return isReactive2(value) || isReadonly(value);
  }
  function toRaw2(observed) {
    return observed && toRaw2(observed["__v_raw"]) || observed;
  }
  function markRaw(value) {
    shared.def(value, "__v_skip", true);
    return value;
  }
  var convert = (val) => shared.isObject(val) ? reactive3(val) : val;
  function isRef(r) {
    return Boolean(r && r.__v_isRef === true);
  }
  function ref(value) {
    return createRef(value);
  }
  function shallowRef(value) {
    return createRef(value, true);
  }
  var RefImpl = class {
    constructor(_rawValue, _shallow = false) {
      this._rawValue = _rawValue;
      this._shallow = _shallow;
      this.__v_isRef = true;
      this._value = _shallow ? _rawValue : convert(_rawValue);
    }
    get value() {
      track(toRaw2(this), "get", "value");
      return this._value;
    }
    set value(newVal) {
      if (shared.hasChanged(toRaw2(newVal), this._rawValue)) {
        this._rawValue = newVal;
        this._value = this._shallow ? newVal : convert(newVal);
        trigger(toRaw2(this), "set", "value", newVal);
      }
    }
  };
  function createRef(rawValue, shallow = false) {
    if (isRef(rawValue)) {
      return rawValue;
    }
    return new RefImpl(rawValue, shallow);
  }
  function triggerRef(ref2) {
    trigger(toRaw2(ref2), "set", "value", ref2.value);
  }
  function unref(ref2) {
    return isRef(ref2) ? ref2.value : ref2;
  }
  var shallowUnwrapHandlers = {
    get: (target, key, receiver) => unref(Reflect.get(target, key, receiver)),
    set: (target, key, value, receiver) => {
      const oldValue = target[key];
      if (isRef(oldValue) && !isRef(value)) {
        oldValue.value = value;
        return true;
      } else {
        return Reflect.set(target, key, value, receiver);
      }
    }
  };
  function proxyRefs(objectWithRefs) {
    return isReactive2(objectWithRefs) ? objectWithRefs : new Proxy(objectWithRefs, shallowUnwrapHandlers);
  }
  var CustomRefImpl = class {
    constructor(factory) {
      this.__v_isRef = true;
      const {get: get3, set: set3} = factory(() => track(this, "get", "value"), () => trigger(this, "set", "value"));
      this._get = get3;
      this._set = set3;
    }
    get value() {
      return this._get();
    }
    set value(newVal) {
      this._set(newVal);
    }
  };
  function customRef(factory) {
    return new CustomRefImpl(factory);
  }
  function toRefs(object) {
    if (!isProxy(object)) {
      console.warn(`toRefs() expects a reactive object but received a plain one.`);
    }
    const ret = shared.isArray(object) ? new Array(object.length) : {};
    for (const key in object) {
      ret[key] = toRef(object, key);
    }
    return ret;
  }
  var ObjectRefImpl = class {
    constructor(_object, _key) {
      this._object = _object;
      this._key = _key;
      this.__v_isRef = true;
    }
    get value() {
      return this._object[this._key];
    }
    set value(newVal) {
      this._object[this._key] = newVal;
    }
  };
  function toRef(object, key) {
    return isRef(object[key]) ? object[key] : new ObjectRefImpl(object, key);
  }
  var ComputedRefImpl = class {
    constructor(getter, _setter, isReadonly2) {
      this._setter = _setter;
      this._dirty = true;
      this.__v_isRef = true;
      this.effect = effect3(getter, {
        lazy: true,
        scheduler: () => {
          if (!this._dirty) {
            this._dirty = true;
            trigger(toRaw2(this), "set", "value");
          }
        }
      });
      this["__v_isReadonly"] = isReadonly2;
    }
    get value() {
      const self2 = toRaw2(this);
      if (self2._dirty) {
        self2._value = this.effect();
        self2._dirty = false;
      }
      track(self2, "get", "value");
      return self2._value;
    }
    set value(newValue) {
      this._setter(newValue);
    }
  };
  function computed(getterOrOptions) {
    let getter;
    let setter;
    if (shared.isFunction(getterOrOptions)) {
      getter = getterOrOptions;
      setter = () => {
        console.warn("Write operation failed: computed value is readonly");
      };
    } else {
      getter = getterOrOptions.get;
      setter = getterOrOptions.set;
    }
    return new ComputedRefImpl(getter, setter, shared.isFunction(getterOrOptions) || !getterOrOptions.set);
  }
  exports.ITERATE_KEY = ITERATE_KEY;
  exports.computed = computed;
  exports.customRef = customRef;
  exports.effect = effect3;
  exports.enableTracking = enableTracking;
  exports.isProxy = isProxy;
  exports.isReactive = isReactive2;
  exports.isReadonly = isReadonly;
  exports.isRef = isRef;
  exports.markRaw = markRaw;
  exports.pauseTracking = pauseTracking;
  exports.proxyRefs = proxyRefs;
  exports.reactive = reactive3;
  exports.readonly = readonly;
  exports.ref = ref;
  exports.resetTracking = resetTracking;
  exports.shallowReactive = shallowReactive;
  exports.shallowReadonly = shallowReadonly;
  exports.shallowRef = shallowRef;
  exports.stop = stop2;
  exports.toRaw = toRaw2;
  exports.toRef = toRef;
  exports.toRefs = toRefs;
  exports.track = track;
  exports.trigger = trigger;
  exports.triggerRef = triggerRef;
  exports.unref = unref;
});

// node_modules/@vue/reactivity/index.js
var require_reactivity = __commonJS((exports, module) => {
  "use strict";
  if (false) {} else {
    module.exports = require_reactivity_cjs();
  }
});

// packages/alpinejs/src/scheduler.js
var flushPending = false;
var flushing = false;
var queue = [];
function scheduler(callback) {
  queueJob(callback);
}
function queueJob(job) {
  if (!queue.includes(job))
    queue.push(job);
  queueFlush();
}
function queueFlush() {
  if (!flushing && !flushPending) {
    flushPending = true;
    queueMicrotask(flushJobs);
  }
}
function flushJobs() {
  flushPending = false;
  flushing = true;
  for (let i = 0; i < queue.length; i++) {
    queue[i]();
  }
  queue.length = 0;
  flushing = false;
}

// packages/alpinejs/src/reactivity.js
var reactive;
var effect;
var release;
var raw;
var shouldSchedule = true;
function disableEffectScheduling(callback) {
  shouldSchedule = false;
  callback();
  shouldSchedule = true;
}
function setReactivityEngine(engine) {
  reactive = engine.reactive;
  release = engine.release;
  effect = (callback) => engine.effect(callback, {scheduler: (task) => {
    if (shouldSchedule) {
      scheduler(task);
    } else {
      task();
    }
  }});
  raw = engine.raw;
}
function overrideEffect(override) {
  effect = override;
}
function elementBoundEffect(el) {
  let cleanup = () => {
  };
  let wrappedEffect = (callback) => {
    let effectReference = effect(callback);
    if (!el._x_effects) {
      el._x_effects = new Set();
      el._x_runEffects = () => {
        el._x_effects.forEach((i) => i());
      };
    }
    el._x_effects.add(effectReference);
    cleanup = () => {
      if (effectReference === void 0)
        return;
      el._x_effects.delete(effectReference);
      release(effectReference);
    };
  };
  return [wrappedEffect, () => {
    cleanup();
  }];
}

// packages/alpinejs/src/mutation.js
var onAttributeAddeds = [];
var onElRemoveds = [];
var onElAddeds = [];
function onElAdded(callback) {
  onElAddeds.push(callback);
}
function onElRemoved(callback) {
  onElRemoveds.push(callback);
}
function onAttributesAdded(callback) {
  onAttributeAddeds.push(callback);
}
function onAttributeRemoved(el, name, callback) {
  if (!el._x_attributeCleanups)
    el._x_attributeCleanups = {};
  if (!el._x_attributeCleanups[name])
    el._x_attributeCleanups[name] = [];
  el._x_attributeCleanups[name].push(callback);
}
function cleanupAttributes(el, names) {
  if (!el._x_attributeCleanups)
    return;
  Object.entries(el._x_attributeCleanups).forEach(([name, value]) => {
    if (names === void 0 || names.includes(name)) {
      value.forEach((i) => i());
      delete el._x_attributeCleanups[name];
    }
  });
}
var observer = new MutationObserver(onMutate);
var currentlyObserving = false;
function startObservingMutations() {
  observer.observe(document, {subtree: true, childList: true, attributes: true, attributeOldValue: true});
  currentlyObserving = true;
}
function stopObservingMutations() {
  flushObserver();
  observer.disconnect();
  currentlyObserving = false;
}
var recordQueue = [];
var willProcessRecordQueue = false;
function flushObserver() {
  recordQueue = recordQueue.concat(observer.takeRecords());
  if (recordQueue.length && !willProcessRecordQueue) {
    willProcessRecordQueue = true;
    queueMicrotask(() => {
      processRecordQueue();
      willProcessRecordQueue = false;
    });
  }
}
function processRecordQueue() {
  onMutate(recordQueue);
  recordQueue.length = 0;
}
function mutateDom(callback) {
  if (!currentlyObserving)
    return callback();
  stopObservingMutations();
  let result = callback();
  startObservingMutations();
  return result;
}
var isCollecting = false;
var deferredMutations = [];
function deferMutations() {
  isCollecting = true;
}
function flushAndStopDeferringMutations() {
  isCollecting = false;
  onMutate(deferredMutations);
  deferredMutations = [];
}
function onMutate(mutations) {
  if (isCollecting) {
    deferredMutations = deferredMutations.concat(mutations);
    return;
  }
  let addedNodes = [];
  let removedNodes = [];
  let addedAttributes = new Map();
  let removedAttributes = new Map();
  for (let i = 0; i < mutations.length; i++) {
    if (mutations[i].target._x_ignoreMutationObserver)
      continue;
    if (mutations[i].type === "childList") {
      mutations[i].addedNodes.forEach((node) => node.nodeType === 1 && addedNodes.push(node));
      mutations[i].removedNodes.forEach((node) => node.nodeType === 1 && removedNodes.push(node));
    }
    if (mutations[i].type === "attributes") {
      let el = mutations[i].target;
      let name = mutations[i].attributeName;
      let oldValue = mutations[i].oldValue;
      let add = () => {
        if (!addedAttributes.has(el))
          addedAttributes.set(el, []);
        addedAttributes.get(el).push({name, value: el.getAttribute(name)});
      };
      let remove = () => {
        if (!removedAttributes.has(el))
          removedAttributes.set(el, []);
        removedAttributes.get(el).push(name);
      };
      if (el.hasAttribute(name) && oldValue === null) {
        add();
      } else if (el.hasAttribute(name)) {
        remove();
        add();
      } else {
        remove();
      }
    }
  }
  removedAttributes.forEach((attrs, el) => {
    cleanupAttributes(el, attrs);
  });
  addedAttributes.forEach((attrs, el) => {
    onAttributeAddeds.forEach((i) => i(el, attrs));
  });
  for (let node of removedNodes) {
    if (addedNodes.includes(node))
      continue;
    onElRemoveds.forEach((i) => i(node));
  }
  addedNodes.forEach((node) => {
    node._x_ignoreSelf = true;
    node._x_ignore = true;
  });
  for (let node of addedNodes) {
    if (removedNodes.includes(node))
      continue;
    if (!node.isConnected)
      continue;
    delete node._x_ignoreSelf;
    delete node._x_ignore;
    onElAddeds.forEach((i) => i(node));
    node._x_ignore = true;
    node._x_ignoreSelf = true;
  }
  addedNodes.forEach((node) => {
    delete node._x_ignoreSelf;
    delete node._x_ignore;
  });
  addedNodes = null;
  removedNodes = null;
  addedAttributes = null;
  removedAttributes = null;
}

// packages/alpinejs/src/scope.js
function addScopeToNode(node, data2, referenceNode) {
  node._x_dataStack = [data2, ...closestDataStack(referenceNode || node)];
  return () => {
    node._x_dataStack = node._x_dataStack.filter((i) => i !== data2);
  };
}
function refreshScope(element, scope) {
  let existingScope = element._x_dataStack[0];
  Object.entries(scope).forEach(([key, value]) => {
    existingScope[key] = value;
  });
}
function closestDataStack(node) {
  if (node._x_dataStack)
    return node._x_dataStack;
  if (typeof ShadowRoot === "function" && node instanceof ShadowRoot) {
    return closestDataStack(node.host);
  }
  if (!node.parentNode) {
    return [];
  }
  return closestDataStack(node.parentNode);
}
function mergeProxies(objects) {
  let thisProxy = new Proxy({}, {
    ownKeys: () => {
      return Array.from(new Set(objects.flatMap((i) => Object.keys(i))));
    },
    has: (target, name) => {
      return objects.some((obj) => obj.hasOwnProperty(name));
    },
    get: (target, name) => {
      return (objects.find((obj) => {
        if (obj.hasOwnProperty(name)) {
          let descriptor = Object.getOwnPropertyDescriptor(obj, name);
          if (descriptor.get && descriptor.get._x_alreadyBound || descriptor.set && descriptor.set._x_alreadyBound) {
            return true;
          }
          if ((descriptor.get || descriptor.set) && descriptor.enumerable) {
            let getter = descriptor.get;
            let setter = descriptor.set;
            let property = descriptor;
            getter = getter && getter.bind(thisProxy);
            setter = setter && setter.bind(thisProxy);
            if (getter)
              getter._x_alreadyBound = true;
            if (setter)
              setter._x_alreadyBound = true;
            Object.defineProperty(obj, name, {
              ...property,
              get: getter,
              set: setter
            });
          }
          return true;
        }
        return false;
      }) || {})[name];
    },
    set: (target, name, value) => {
      let closestObjectWithKey = objects.find((obj) => obj.hasOwnProperty(name));
      if (closestObjectWithKey) {
        closestObjectWithKey[name] = value;
      } else {
        objects[objects.length - 1][name] = value;
      }
      return true;
    }
  });
  return thisProxy;
}

// packages/alpinejs/src/interceptor.js
function initInterceptors(data2) {
  let isObject = (val) => typeof val === "object" && !Array.isArray(val) && val !== null;
  let recurse = (obj, basePath = "") => {
    Object.entries(Object.getOwnPropertyDescriptors(obj)).forEach(([key, {value, enumerable}]) => {
      if (enumerable === false || value === void 0)
        return;
      let path = basePath === "" ? key : `${basePath}.${key}`;
      if (typeof value === "object" && value !== null && value._x_interceptor) {
        obj[key] = value.initialize(data2, path, key);
      } else {
        if (isObject(value) && value !== obj && !(value instanceof Element)) {
          recurse(value, path);
        }
      }
    });
  };
  return recurse(data2);
}
function interceptor(callback, mutateObj = () => {
}) {
  let obj = {
    initialValue: void 0,
    _x_interceptor: true,
    initialize(data2, path, key) {
      return callback(this.initialValue, () => get(data2, path), (value) => set(data2, path, value), path, key);
    }
  };
  mutateObj(obj);
  return (initialValue) => {
    if (typeof initialValue === "object" && initialValue !== null && initialValue._x_interceptor) {
      let initialize = obj.initialize.bind(obj);
      obj.initialize = (data2, path, key) => {
        let innerValue = initialValue.initialize(data2, path, key);
        obj.initialValue = innerValue;
        return initialize(data2, path, key);
      };
    } else {
      obj.initialValue = initialValue;
    }
    return obj;
  };
}
function get(obj, path) {
  return path.split(".").reduce((carry, segment) => carry[segment], obj);
}
function set(obj, path, value) {
  if (typeof path === "string")
    path = path.split(".");
  if (path.length === 1)
    obj[path[0]] = value;
  else if (path.length === 0)
    throw error;
  else {
    if (obj[path[0]])
      return set(obj[path[0]], path.slice(1), value);
    else {
      obj[path[0]] = {};
      return set(obj[path[0]], path.slice(1), value);
    }
  }
}

// packages/alpinejs/src/magics.js
var magics = {};
function magic(name, callback) {
  magics[name] = callback;
}
function injectMagics(obj, el) {
  Object.entries(magics).forEach(([name, callback]) => {
    Object.defineProperty(obj, `$${name}`, {
      get() {
        return callback(el, {Alpine: alpine_default, interceptor});
      },
      enumerable: false
    });
  });
  return obj;
}

// packages/alpinejs/src/utils/error.js
function tryCatch(el, expression, callback, ...args) {
  try {
    return callback(...args);
  } catch (e) {
    handleError(e, el, expression);
  }
}
function handleError(error2, el, expression = void 0) {
  Object.assign(error2, {el, expression});
  console.warn(`Alpine Expression Error: ${error2.message}

${expression ? 'Expression: "' + expression + '"\n\n' : ""}`, el);
  setTimeout(() => {
    throw error2;
  }, 0);
}

// packages/alpinejs/src/evaluator.js
function evaluate(el, expression, extras = {}) {
  let result;
  evaluateLater(el, expression)((value) => result = value, extras);
  return result;
}
function evaluateLater(...args) {
  return theEvaluatorFunction(...args);
}
var theEvaluatorFunction = normalEvaluator;
function setEvaluator(newEvaluator) {
  theEvaluatorFunction = newEvaluator;
}
function normalEvaluator(el, expression) {
  let overriddenMagics = {};
  injectMagics(overriddenMagics, el);
  let dataStack = [overriddenMagics, ...closestDataStack(el)];
  if (typeof expression === "function") {
    return generateEvaluatorFromFunction(dataStack, expression);
  }
  let evaluator = generateEvaluatorFromString(dataStack, expression, el);
  return tryCatch.bind(null, el, expression, evaluator);
}
function generateEvaluatorFromFunction(dataStack, func) {
  return (receiver = () => {
  }, {scope = {}, params = []} = {}) => {
    let result = func.apply(mergeProxies([scope, ...dataStack]), params);
    runIfTypeOfFunction(receiver, result);
  };
}
var evaluatorMemo = {};
function generateFunctionFromString(expression, el) {
  if (evaluatorMemo[expression]) {
    return evaluatorMemo[expression];
  }
  let AsyncFunction = Object.getPrototypeOf(async function() {
  }).constructor;
  let rightSideSafeExpression = /^[\n\s]*if.*\(.*\)/.test(expression) || /^(let|const)\s/.test(expression) ? `(() => { ${expression} })()` : expression;
  const safeAsyncFunction = () => {
    try {
      return new AsyncFunction(["__self", "scope"], `with (scope) { __self.result = ${rightSideSafeExpression} }; __self.finished = true; return __self.result;`);
    } catch (error2) {
      handleError(error2, el, expression);
      return Promise.resolve();
    }
  };
  let func = safeAsyncFunction();
  evaluatorMemo[expression] = func;
  return func;
}
function generateEvaluatorFromString(dataStack, expression, el) {
  let func = generateFunctionFromString(expression, el);
  return (receiver = () => {
  }, {scope = {}, params = []} = {}) => {
    func.result = void 0;
    func.finished = false;
    let completeScope = mergeProxies([scope, ...dataStack]);
    if (typeof func === "function") {
      let promise = func(func, completeScope).catch((error2) => handleError(error2, el, expression));
      if (func.finished) {
        runIfTypeOfFunction(receiver, func.result, completeScope, params, el);
        func.result = void 0;
      } else {
        promise.then((result) => {
          runIfTypeOfFunction(receiver, result, completeScope, params, el);
        }).catch((error2) => handleError(error2, el, expression)).finally(() => func.result = void 0);
      }
    }
  };
}
function runIfTypeOfFunction(receiver, value, scope, params, el) {
  if (typeof value === "function") {
    let result = value.apply(scope, params);
    if (result instanceof Promise) {
      result.then((i) => runIfTypeOfFunction(receiver, i, scope, params)).catch((error2) => handleError(error2, el, value));
    } else {
      receiver(result);
    }
  } else {
    receiver(value);
  }
}

// packages/alpinejs/src/directives.js
var prefixAsString = "x-";
function prefix(subject = "") {
  return prefixAsString + subject;
}
function setPrefix(newPrefix) {
  prefixAsString = newPrefix;
}
var directiveHandlers = {};
function directive(name, callback) {
  directiveHandlers[name] = callback;
}
function directives(el, attributes, originalAttributeOverride) {
  let transformedAttributeMap = {};
  let directives2 = Array.from(attributes).map(toTransformedAttributes((newName, oldName) => transformedAttributeMap[newName] = oldName)).filter(outNonAlpineAttributes).map(toParsedDirectives(transformedAttributeMap, originalAttributeOverride)).sort(byPriority);
  return directives2.map((directive2) => {
    return getDirectiveHandler(el, directive2);
  });
}
function attributesOnly(attributes) {
  return Array.from(attributes).map(toTransformedAttributes()).filter((attr) => !outNonAlpineAttributes(attr));
}
var isDeferringHandlers = false;
var directiveHandlerStacks = new Map();
var currentHandlerStackKey = Symbol();
function deferHandlingDirectives(callback) {
  isDeferringHandlers = true;
  let key = Symbol();
  currentHandlerStackKey = key;
  directiveHandlerStacks.set(key, []);
  let flushHandlers = () => {
    while (directiveHandlerStacks.get(key).length)
      directiveHandlerStacks.get(key).shift()();
    directiveHandlerStacks.delete(key);
  };
  let stopDeferring = () => {
    isDeferringHandlers = false;
    flushHandlers();
  };
  callback(flushHandlers);
  stopDeferring();
}
function getDirectiveHandler(el, directive2) {
  let noop = () => {
  };
  let handler3 = directiveHandlers[directive2.type] || noop;
  let cleanups = [];
  let cleanup = (callback) => cleanups.push(callback);
  let [effect3, cleanupEffect] = elementBoundEffect(el);
  cleanups.push(cleanupEffect);
  let utilities = {
    Alpine: alpine_default,
    effect: effect3,
    cleanup,
    evaluateLater: evaluateLater.bind(evaluateLater, el),
    evaluate: evaluate.bind(evaluate, el)
  };
  let doCleanup = () => cleanups.forEach((i) => i());
  onAttributeRemoved(el, directive2.original, doCleanup);
  let fullHandler = () => {
    if (el._x_ignore || el._x_ignoreSelf)
      return;
    handler3.inline && handler3.inline(el, directive2, utilities);
    handler3 = handler3.bind(handler3, el, directive2, utilities);
    isDeferringHandlers ? directiveHandlerStacks.get(currentHandlerStackKey).push(handler3) : handler3();
  };
  fullHandler.runCleanups = doCleanup;
  return fullHandler;
}
var startingWith = (subject, replacement) => ({name, value}) => {
  if (name.startsWith(subject))
    name = name.replace(subject, replacement);
  return {name, value};
};
var into = (i) => i;
function toTransformedAttributes(callback = () => {
}) {
  return ({name, value}) => {
    let {name: newName, value: newValue} = attributeTransformers.reduce((carry, transform) => {
      return transform(carry);
    }, {name, value});
    if (newName !== name)
      callback(newName, name);
    return {name: newName, value: newValue};
  };
}
var attributeTransformers = [];
function mapAttributes(callback) {
  attributeTransformers.push(callback);
}
function outNonAlpineAttributes({name}) {
  return alpineAttributeRegex().test(name);
}
var alpineAttributeRegex = () => new RegExp(`^${prefixAsString}([^:^.]+)\\b`);
function toParsedDirectives(transformedAttributeMap, originalAttributeOverride) {
  return ({name, value}) => {
    let typeMatch = name.match(alpineAttributeRegex());
    let valueMatch = name.match(/:([a-zA-Z0-9\-:]+)/);
    let modifiers = name.match(/\.[^.\]]+(?=[^\]]*$)/g) || [];
    let original = originalAttributeOverride || transformedAttributeMap[name] || name;
    return {
      type: typeMatch ? typeMatch[1] : null,
      value: valueMatch ? valueMatch[1] : null,
      modifiers: modifiers.map((i) => i.replace(".", "")),
      expression: value,
      original
    };
  };
}
var DEFAULT = "DEFAULT";
var directiveOrder = [
  "ignore",
  "ref",
  "data",
  "id",
  "bind",
  "init",
  "for",
  "model",
  "transition",
  "show",
  "if",
  DEFAULT,
  "teleport",
  "element"
];
function byPriority(a, b) {
  let typeA = directiveOrder.indexOf(a.type) === -1 ? DEFAULT : a.type;
  let typeB = directiveOrder.indexOf(b.type) === -1 ? DEFAULT : b.type;
  return directiveOrder.indexOf(typeA) - directiveOrder.indexOf(typeB);
}

// packages/alpinejs/src/utils/dispatch.js
function dispatch(el, name, detail = {}) {
  el.dispatchEvent(new CustomEvent(name, {
    detail,
    bubbles: true,
    composed: true,
    cancelable: true
  }));
}

// packages/alpinejs/src/nextTick.js
var tickStack = [];
var isHolding = false;
function nextTick(callback) {
  tickStack.push(callback);
  queueMicrotask(() => {
    isHolding || setTimeout(() => {
      releaseNextTicks();
    });
  });
}
function releaseNextTicks() {
  isHolding = false;
  while (tickStack.length)
    tickStack.shift()();
}
function holdNextTicks() {
  isHolding = true;
}

// packages/alpinejs/src/utils/walk.js
function walk(el, callback) {
  if (typeof ShadowRoot === "function" && el instanceof ShadowRoot) {
    Array.from(el.children).forEach((el2) => walk(el2, callback));
    return;
  }
  let skip = false;
  callback(el, () => skip = true);
  if (skip)
    return;
  let node = el.firstElementChild;
  while (node) {
    walk(node, callback, false);
    node = node.nextElementSibling;
  }
}

// packages/alpinejs/src/utils/warn.js
function warn(message, ...args) {
  console.warn(`Alpine Warning: ${message}`, ...args);
}

// packages/alpinejs/src/lifecycle.js
function start() {
  if (!document.body)
    warn("Unable to initialize. Trying to load Alpine before `<body>` is available. Did you forget to add `defer` in Alpine's `<script>` tag?");
  dispatch(document, "alpine:init");
  dispatch(document, "alpine:initializing");
  startObservingMutations();
  onElAdded((el) => initTree(el, walk));
  onElRemoved((el) => destroyTree(el));
  onAttributesAdded((el, attrs) => {
    directives(el, attrs).forEach((handle) => handle());
  });
  let outNestedComponents = (el) => !closestRoot(el.parentElement, true);
  Array.from(document.querySelectorAll(allSelectors())).filter(outNestedComponents).forEach((el) => {
    initTree(el);
  });
  dispatch(document, "alpine:initialized");
}
var rootSelectorCallbacks = [];
var initSelectorCallbacks = [];
function rootSelectors() {
  return rootSelectorCallbacks.map((fn) => fn());
}
function allSelectors() {
  return rootSelectorCallbacks.concat(initSelectorCallbacks).map((fn) => fn());
}
function addRootSelector(selectorCallback) {
  rootSelectorCallbacks.push(selectorCallback);
}
function addInitSelector(selectorCallback) {
  initSelectorCallbacks.push(selectorCallback);
}
function closestRoot(el, includeInitSelectors = false) {
  return findClosest(el, (element) => {
    const selectors = includeInitSelectors ? allSelectors() : rootSelectors();
    if (selectors.some((selector) => element.matches(selector)))
      return true;
  });
}
function findClosest(el, callback) {
  if (!el)
    return;
  if (callback(el))
    return el;
  if (el._x_teleportBack)
    el = el._x_teleportBack;
  if (!el.parentElement)
    return;
  return findClosest(el.parentElement, callback);
}
function isRoot(el) {
  return rootSelectors().some((selector) => el.matches(selector));
}
function initTree(el, walker = walk) {
  deferHandlingDirectives(() => {
    walker(el, (el2, skip) => {
      directives(el2, el2.attributes).forEach((handle) => handle());
      el2._x_ignore && skip();
    });
  });
}
function destroyTree(root) {
  walk(root, (el) => cleanupAttributes(el));
}

// packages/alpinejs/src/utils/classes.js
function setClasses(el, value) {
  if (Array.isArray(value)) {
    return setClassesFromString(el, value.join(" "));
  } else if (typeof value === "object" && value !== null) {
    return setClassesFromObject(el, value);
  } else if (typeof value === "function") {
    return setClasses(el, value());
  }
  return setClassesFromString(el, value);
}
function setClassesFromString(el, classString) {
  let split = (classString2) => classString2.split(" ").filter(Boolean);
  let missingClasses = (classString2) => classString2.split(" ").filter((i) => !el.classList.contains(i)).filter(Boolean);
  let addClassesAndReturnUndo = (classes) => {
    el.classList.add(...classes);
    return () => {
      el.classList.remove(...classes);
    };
  };
  classString = classString === true ? classString = "" : classString || "";
  return addClassesAndReturnUndo(missingClasses(classString));
}
function setClassesFromObject(el, classObject) {
  let split = (classString) => classString.split(" ").filter(Boolean);
  let forAdd = Object.entries(classObject).flatMap(([classString, bool]) => bool ? split(classString) : false).filter(Boolean);
  let forRemove = Object.entries(classObject).flatMap(([classString, bool]) => !bool ? split(classString) : false).filter(Boolean);
  let added = [];
  let removed = [];
  forRemove.forEach((i) => {
    if (el.classList.contains(i)) {
      el.classList.remove(i);
      removed.push(i);
    }
  });
  forAdd.forEach((i) => {
    if (!el.classList.contains(i)) {
      el.classList.add(i);
      added.push(i);
    }
  });
  return () => {
    removed.forEach((i) => el.classList.add(i));
    added.forEach((i) => el.classList.remove(i));
  };
}

// packages/alpinejs/src/utils/styles.js
function setStyles(el, value) {
  if (typeof value === "object" && value !== null) {
    return setStylesFromObject(el, value);
  }
  return setStylesFromString(el, value);
}
function setStylesFromObject(el, value) {
  let previousStyles = {};
  Object.entries(value).forEach(([key, value2]) => {
    previousStyles[key] = el.style[key];
    el.style.setProperty(kebabCase(key), value2);
  });
  setTimeout(() => {
    if (el.style.length === 0) {
      el.removeAttribute("style");
    }
  });
  return () => {
    setStyles(el, previousStyles);
  };
}
function setStylesFromString(el, value) {
  let cache = el.getAttribute("style", value);
  el.setAttribute("style", value);
  return () => {
    el.setAttribute("style", cache || "");
  };
}
function kebabCase(subject) {
  return subject.replace(/([a-z])([A-Z])/g, "$1-$2").toLowerCase();
}

// packages/alpinejs/src/utils/once.js
function once(callback, fallback = () => {
}) {
  let called = false;
  return function() {
    if (!called) {
      called = true;
      callback.apply(this, arguments);
    } else {
      fallback.apply(this, arguments);
    }
  };
}

// packages/alpinejs/src/directives/x-transition.js
directive("transition", (el, {value, modifiers, expression}, {evaluate: evaluate2}) => {
  if (typeof expression === "function")
    expression = evaluate2(expression);
  if (!expression) {
    registerTransitionsFromHelper(el, modifiers, value);
  } else {
    registerTransitionsFromClassString(el, expression, value);
  }
});
function registerTransitionsFromClassString(el, classString, stage) {
  registerTransitionObject(el, setClasses, "");
  let directiveStorageMap = {
    enter: (classes) => {
      el._x_transition.enter.during = classes;
    },
    "enter-start": (classes) => {
      el._x_transition.enter.start = classes;
    },
    "enter-end": (classes) => {
      el._x_transition.enter.end = classes;
    },
    leave: (classes) => {
      el._x_transition.leave.during = classes;
    },
    "leave-start": (classes) => {
      el._x_transition.leave.start = classes;
    },
    "leave-end": (classes) => {
      el._x_transition.leave.end = classes;
    }
  };
  directiveStorageMap[stage](classString);
}
function registerTransitionsFromHelper(el, modifiers, stage) {
  registerTransitionObject(el, setStyles);
  let doesntSpecify = !modifiers.includes("in") && !modifiers.includes("out") && !stage;
  let transitioningIn = doesntSpecify || modifiers.includes("in") || ["enter"].includes(stage);
  let transitioningOut = doesntSpecify || modifiers.includes("out") || ["leave"].includes(stage);
  if (modifiers.includes("in") && !doesntSpecify) {
    modifiers = modifiers.filter((i, index) => index < modifiers.indexOf("out"));
  }
  if (modifiers.includes("out") && !doesntSpecify) {
    modifiers = modifiers.filter((i, index) => index > modifiers.indexOf("out"));
  }
  let wantsAll = !modifiers.includes("opacity") && !modifiers.includes("scale");
  let wantsOpacity = wantsAll || modifiers.includes("opacity");
  let wantsScale = wantsAll || modifiers.includes("scale");
  let opacityValue = wantsOpacity ? 0 : 1;
  let scaleValue = wantsScale ? modifierValue(modifiers, "scale", 95) / 100 : 1;
  let delay = modifierValue(modifiers, "delay", 0);
  let origin = modifierValue(modifiers, "origin", "center");
  let property = "opacity, transform";
  let durationIn = modifierValue(modifiers, "duration", 150) / 1e3;
  let durationOut = modifierValue(modifiers, "duration", 75) / 1e3;
  let easing = `cubic-bezier(0.4, 0.0, 0.2, 1)`;
  if (transitioningIn) {
    el._x_transition.enter.during = {
      transformOrigin: origin,
      transitionDelay: delay,
      transitionProperty: property,
      transitionDuration: `${durationIn}s`,
      transitionTimingFunction: easing
    };
    el._x_transition.enter.start = {
      opacity: opacityValue,
      transform: `scale(${scaleValue})`
    };
    el._x_transition.enter.end = {
      opacity: 1,
      transform: `scale(1)`
    };
  }
  if (transitioningOut) {
    el._x_transition.leave.during = {
      transformOrigin: origin,
      transitionDelay: delay,
      transitionProperty: property,
      transitionDuration: `${durationOut}s`,
      transitionTimingFunction: easing
    };
    el._x_transition.leave.start = {
      opacity: 1,
      transform: `scale(1)`
    };
    el._x_transition.leave.end = {
      opacity: opacityValue,
      transform: `scale(${scaleValue})`
    };
  }
}
function registerTransitionObject(el, setFunction, defaultValue = {}) {
  if (!el._x_transition)
    el._x_transition = {
      enter: {during: defaultValue, start: defaultValue, end: defaultValue},
      leave: {during: defaultValue, start: defaultValue, end: defaultValue},
      in(before = () => {
      }, after = () => {
      }) {
        transition(el, setFunction, {
          during: this.enter.during,
          start: this.enter.start,
          end: this.enter.end
        }, before, after);
      },
      out(before = () => {
      }, after = () => {
      }) {
        transition(el, setFunction, {
          during: this.leave.during,
          start: this.leave.start,
          end: this.leave.end
        }, before, after);
      }
    };
}
window.Element.prototype._x_toggleAndCascadeWithTransitions = function(el, value, show, hide) {
  let clickAwayCompatibleShow = () => {
    document.visibilityState === "visible" ? requestAnimationFrame(show) : setTimeout(show);
  };
  if (value) {
    if (el._x_transition && (el._x_transition.enter || el._x_transition.leave)) {
      el._x_transition.enter && (Object.entries(el._x_transition.enter.during).length || Object.entries(el._x_transition.enter.start).length || Object.entries(el._x_transition.enter.end).length) ? el._x_transition.in(show) : clickAwayCompatibleShow();
    } else {
      el._x_transition ? el._x_transition.in(show) : clickAwayCompatibleShow();
    }
    return;
  }
  el._x_hidePromise = el._x_transition ? new Promise((resolve, reject) => {
    el._x_transition.out(() => {
    }, () => resolve(hide));
    el._x_transitioning.beforeCancel(() => reject({isFromCancelledTransition: true}));
  }) : Promise.resolve(hide);
  queueMicrotask(() => {
    let closest = closestHide(el);
    if (closest) {
      if (!closest._x_hideChildren)
        closest._x_hideChildren = [];
      closest._x_hideChildren.push(el);
    } else {
      queueMicrotask(() => {
        let hideAfterChildren = (el2) => {
          let carry = Promise.all([
            el2._x_hidePromise,
            ...(el2._x_hideChildren || []).map(hideAfterChildren)
          ]).then(([i]) => i());
          delete el2._x_hidePromise;
          delete el2._x_hideChildren;
          return carry;
        };
        hideAfterChildren(el).catch((e) => {
          if (!e.isFromCancelledTransition)
            throw e;
        });
      });
    }
  });
};
function closestHide(el) {
  let parent = el.parentNode;
  if (!parent)
    return;
  return parent._x_hidePromise ? parent : closestHide(parent);
}
function transition(el, setFunction, {during, start: start2, end} = {}, before = () => {
}, after = () => {
}) {
  if (el._x_transitioning)
    el._x_transitioning.cancel();
  if (Object.keys(during).length === 0 && Object.keys(start2).length === 0 && Object.keys(end).length === 0) {
    before();
    after();
    return;
  }
  let undoStart, undoDuring, undoEnd;
  performTransition(el, {
    start() {
      undoStart = setFunction(el, start2);
    },
    during() {
      undoDuring = setFunction(el, during);
    },
    before,
    end() {
      undoStart();
      undoEnd = setFunction(el, end);
    },
    after,
    cleanup() {
      undoDuring();
      undoEnd();
    }
  });
}
function performTransition(el, stages) {
  let interrupted, reachedBefore, reachedEnd;
  let finish = once(() => {
    mutateDom(() => {
      interrupted = true;
      if (!reachedBefore)
        stages.before();
      if (!reachedEnd) {
        stages.end();
        releaseNextTicks();
      }
      stages.after();
      if (el.isConnected)
        stages.cleanup();
      delete el._x_transitioning;
    });
  });
  el._x_transitioning = {
    beforeCancels: [],
    beforeCancel(callback) {
      this.beforeCancels.push(callback);
    },
    cancel: once(function() {
      while (this.beforeCancels.length) {
        this.beforeCancels.shift()();
      }
      ;
      finish();
    }),
    finish
  };
  mutateDom(() => {
    stages.start();
    stages.during();
  });
  holdNextTicks();
  requestAnimationFrame(() => {
    if (interrupted)
      return;
    let duration = Number(getComputedStyle(el).transitionDuration.replace(/,.*/, "").replace("s", "")) * 1e3;
    let delay = Number(getComputedStyle(el).transitionDelay.replace(/,.*/, "").replace("s", "")) * 1e3;
    if (duration === 0)
      duration = Number(getComputedStyle(el).animationDuration.replace("s", "")) * 1e3;
    mutateDom(() => {
      stages.before();
    });
    reachedBefore = true;
    requestAnimationFrame(() => {
      if (interrupted)
        return;
      mutateDom(() => {
        stages.end();
      });
      releaseNextTicks();
      setTimeout(el._x_transitioning.finish, duration + delay);
      reachedEnd = true;
    });
  });
}
function modifierValue(modifiers, key, fallback) {
  if (modifiers.indexOf(key) === -1)
    return fallback;
  const rawValue = modifiers[modifiers.indexOf(key) + 1];
  if (!rawValue)
    return fallback;
  if (key === "scale") {
    if (isNaN(rawValue))
      return fallback;
  }
  if (key === "duration") {
    let match = rawValue.match(/([0-9]+)ms/);
    if (match)
      return match[1];
  }
  if (key === "origin") {
    if (["top", "right", "left", "center", "bottom"].includes(modifiers[modifiers.indexOf(key) + 2])) {
      return [rawValue, modifiers[modifiers.indexOf(key) + 2]].join(" ");
    }
  }
  return rawValue;
}

// packages/alpinejs/src/clone.js
var isCloning = false;
function skipDuringClone(callback, fallback = () => {
}) {
  return (...args) => isCloning ? fallback(...args) : callback(...args);
}
function clone(oldEl, newEl) {
  if (!newEl._x_dataStack)
    newEl._x_dataStack = oldEl._x_dataStack;
  isCloning = true;
  dontRegisterReactiveSideEffects(() => {
    cloneTree(newEl);
  });
  isCloning = false;
}
function cloneTree(el) {
  let hasRunThroughFirstEl = false;
  let shallowWalker = (el2, callback) => {
    walk(el2, (el3, skip) => {
      if (hasRunThroughFirstEl && isRoot(el3))
        return skip();
      hasRunThroughFirstEl = true;
      callback(el3, skip);
    });
  };
  initTree(el, shallowWalker);
}
function dontRegisterReactiveSideEffects(callback) {
  let cache = effect;
  overrideEffect((callback2, el) => {
    let storedEffect = cache(callback2);
    release(storedEffect);
    return () => {
    };
  });
  callback();
  overrideEffect(cache);
}

// packages/alpinejs/src/utils/debounce.js
function debounce(func, wait) {
  var timeout;
  return function() {
    var context = this, args = arguments;
    var later = function() {
      timeout = null;
      func.apply(context, args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// packages/alpinejs/src/utils/throttle.js
function throttle(func, limit) {
  let inThrottle;
  return function() {
    let context = this, args = arguments;
    if (!inThrottle) {
      func.apply(context, args);
      inThrottle = true;
      setTimeout(() => inThrottle = false, limit);
    }
  };
}

// packages/alpinejs/src/plugin.js
function plugin(callback) {
  callback(alpine_default);
}

// packages/alpinejs/src/store.js
var stores = {};
var isReactive = false;
function store(name, value) {
  if (!isReactive) {
    stores = reactive(stores);
    isReactive = true;
  }
  if (value === void 0) {
    return stores[name];
  }
  stores[name] = value;
  if (typeof value === "object" && value !== null && value.hasOwnProperty("init") && typeof value.init === "function") {
    stores[name].init();
  }
  initInterceptors(stores[name]);
}
function getStores() {
  return stores;
}

// packages/alpinejs/src/datas.js
var datas = {};
function data(name, callback) {
  datas[name] = callback;
}
function injectDataProviders(obj, context) {
  Object.entries(datas).forEach(([name, callback]) => {
    Object.defineProperty(obj, name, {
      get() {
        return (...args) => {
          return callback.bind(context)(...args);
        };
      },
      enumerable: false
    });
  });
  return obj;
}

// packages/alpinejs/src/alpine.js
var Alpine = {
  get reactive() {
    return reactive;
  },
  get release() {
    return release;
  },
  get effect() {
    return effect;
  },
  get raw() {
    return raw;
  },
  version: "3.7.1",
  flushAndStopDeferringMutations,
  disableEffectScheduling,
  setReactivityEngine,
  closestDataStack,
  skipDuringClone,
  addRootSelector,
  addInitSelector,
  addScopeToNode,
  deferMutations,
  mapAttributes,
  evaluateLater,
  setEvaluator,
  mergeProxies,
  closestRoot,
  interceptor,
  transition,
  setStyles,
  mutateDom,
  directive,
  throttle,
  debounce,
  evaluate,
  initTree,
  nextTick,
  prefixed: prefix,
  prefix: setPrefix,
  plugin,
  magic,
  store,
  start,
  clone,
  data
};
var alpine_default = Alpine;

// packages/alpinejs/src/index.js
var import_reactivity9 = __toModule(require_reactivity());

// packages/alpinejs/src/magics/$nextTick.js
magic("nextTick", () => nextTick);

// packages/alpinejs/src/magics/$dispatch.js
magic("dispatch", (el) => dispatch.bind(dispatch, el));

// packages/alpinejs/src/magics/$watch.js
magic("watch", (el) => (key, callback) => {
  let evaluate2 = evaluateLater(el, key);
  let firstTime = true;
  let oldValue;
  effect(() => evaluate2((value) => {
    JSON.stringify(value);
    if (!firstTime) {
      queueMicrotask(() => {
        callback(value, oldValue);
        oldValue = value;
      });
    } else {
      oldValue = value;
    }
    firstTime = false;
  }));
});

// packages/alpinejs/src/magics/$store.js
magic("store", getStores);

// packages/alpinejs/src/magics/$data.js
magic("data", (el) => {
  return mergeProxies(closestDataStack(el));
});

// packages/alpinejs/src/magics/$root.js
magic("root", (el) => closestRoot(el));

// packages/alpinejs/src/magics/$refs.js
magic("refs", (el) => {
  if (el._x_refs_proxy)
    return el._x_refs_proxy;
  el._x_refs_proxy = mergeProxies(getArrayOfRefObject(el));
  return el._x_refs_proxy;
});
function getArrayOfRefObject(el) {
  let refObjects = [];
  let currentEl = el;
  while (currentEl) {
    if (currentEl._x_refs)
      refObjects.push(currentEl._x_refs);
    currentEl = currentEl.parentNode;
  }
  return refObjects;
}

// packages/alpinejs/src/ids.js
var globalIdMemo = {};
function findAndIncrementId(name) {
  if (!globalIdMemo[name])
    globalIdMemo[name] = 0;
  return ++globalIdMemo[name];
}
function closestIdRoot(el, name) {
  return findClosest(el, (element) => {
    if (element._x_ids && element._x_ids[name])
      return true;
  });
}
function setIdRoot(el, name) {
  if (!el._x_ids)
    el._x_ids = {};
  if (!el._x_ids[name])
    el._x_ids[name] = findAndIncrementId(name);
}

// packages/alpinejs/src/magics/$id.js
magic("id", (el) => (name, key = null) => {
  let root = closestIdRoot(el, name);
  let id = root ? root._x_ids[name] : findAndIncrementId(name);
  return key ? new AlpineId(`${name}-${id}-${key}`) : new AlpineId(`${name}-${id}`);
});
var AlpineId = class {
  constructor(id) {
    this.id = id;
  }
  toString() {
    return this.id;
  }
};

// packages/alpinejs/src/magics/$el.js
magic("el", (el) => el);

// packages/alpinejs/src/directives/x-teleport.js
directive("teleport", (el, {expression}, {cleanup}) => {
  if (el.tagName.toLowerCase() !== "template")
    warn("x-teleport can only be used on a <template> tag", el);
  let target = document.querySelector(expression);
  if (!target)
    warn(`Cannot find x-teleport element for selector: "${expression}"`);
  let clone2 = el.content.cloneNode(true).firstElementChild;
  el._x_teleport = clone2;
  clone2._x_teleportBack = el;
  if (el._x_forwardEvents) {
    el._x_forwardEvents.forEach((eventName) => {
      clone2.addEventListener(eventName, (e) => {
        e.stopPropagation();
        el.dispatchEvent(new e.constructor(e.type, e));
      });
    });
  }
  addScopeToNode(clone2, {}, el);
  mutateDom(() => {
    target.appendChild(clone2);
    initTree(clone2);
    clone2._x_ignore = true;
  });
  cleanup(() => clone2.remove());
});

// packages/alpinejs/src/directives/x-ignore.js
var handler = () => {
};
handler.inline = (el, {modifiers}, {cleanup}) => {
  modifiers.includes("self") ? el._x_ignoreSelf = true : el._x_ignore = true;
  cleanup(() => {
    modifiers.includes("self") ? delete el._x_ignoreSelf : delete el._x_ignore;
  });
};
directive("ignore", handler);

// packages/alpinejs/src/directives/x-effect.js
directive("effect", (el, {expression}, {effect: effect3}) => effect3(evaluateLater(el, expression)));

// packages/alpinejs/src/utils/bind.js
function bind(el, name, value, modifiers = []) {
  if (!el._x_bindings)
    el._x_bindings = reactive({});
  el._x_bindings[name] = value;
  name = modifiers.includes("camel") ? camelCase(name) : name;
  switch (name) {
    case "value":
      bindInputValue(el, value);
      break;
    case "style":
      bindStyles(el, value);
      break;
    case "class":
      bindClasses(el, value);
      break;
    default:
      bindAttribute(el, name, value);
      break;
  }
}
function bindInputValue(el, value) {
  if (el.type === "radio") {
    if (el.attributes.value === void 0) {
      el.value = value;
    }
    if (window.fromModel) {
      el.checked = checkedAttrLooseCompare(el.value, value);
    }
  } else if (el.type === "checkbox") {
    if (Number.isInteger(value)) {
      el.value = value;
    } else if (!Number.isInteger(value) && !Array.isArray(value) && typeof value !== "boolean" && ![null, void 0].includes(value)) {
      el.value = String(value);
    } else {
      if (Array.isArray(value)) {
        el.checked = value.some((val) => checkedAttrLooseCompare(val, el.value));
      } else {
        el.checked = !!value;
      }
    }
  } else if (el.tagName === "SELECT") {
    updateSelect(el, value);
  } else {
    if (el.value === value)
      return;
    el.value = value;
  }
}
function bindClasses(el, value) {
  if (el._x_undoAddedClasses)
    el._x_undoAddedClasses();
  el._x_undoAddedClasses = setClasses(el, value);
}
function bindStyles(el, value) {
  if (el._x_undoAddedStyles)
    el._x_undoAddedStyles();
  el._x_undoAddedStyles = setStyles(el, value);
}
function bindAttribute(el, name, value) {
  if ([null, void 0, false].includes(value) && attributeShouldntBePreservedIfFalsy(name)) {
    el.removeAttribute(name);
  } else {
    if (isBooleanAttr(name))
      value = name;
    setIfChanged(el, name, value);
  }
}
function setIfChanged(el, attrName, value) {
  if (el.getAttribute(attrName) != value) {
    el.setAttribute(attrName, value);
  }
}
function updateSelect(el, value) {
  const arrayWrappedValue = [].concat(value).map((value2) => {
    return value2 + "";
  });
  Array.from(el.options).forEach((option) => {
    option.selected = arrayWrappedValue.includes(option.value);
  });
}
function camelCase(subject) {
  return subject.toLowerCase().replace(/-(\w)/g, (match, char) => char.toUpperCase());
}
function checkedAttrLooseCompare(valueA, valueB) {
  return valueA == valueB;
}
function isBooleanAttr(attrName) {
  const booleanAttributes = [
    "disabled",
    "checked",
    "required",
    "readonly",
    "hidden",
    "open",
    "selected",
    "autofocus",
    "itemscope",
    "multiple",
    "novalidate",
    "allowfullscreen",
    "allowpaymentrequest",
    "formnovalidate",
    "autoplay",
    "controls",
    "loop",
    "muted",
    "playsinline",
    "default",
    "ismap",
    "reversed",
    "async",
    "defer",
    "nomodule"
  ];
  return booleanAttributes.includes(attrName);
}
function attributeShouldntBePreservedIfFalsy(name) {
  return !["aria-pressed", "aria-checked", "aria-expanded"].includes(name);
}

// packages/alpinejs/src/utils/on.js
function on(el, event, modifiers, callback) {
  let listenerTarget = el;
  let handler3 = (e) => callback(e);
  let options = {};
  let wrapHandler = (callback2, wrapper) => (e) => wrapper(callback2, e);
  if (modifiers.includes("dot"))
    event = dotSyntax(event);
  if (modifiers.includes("camel"))
    event = camelCase2(event);
  if (modifiers.includes("passive"))
    options.passive = true;
  if (modifiers.includes("capture"))
    options.capture = true;
  if (modifiers.includes("window"))
    listenerTarget = window;
  if (modifiers.includes("document"))
    listenerTarget = document;
  if (modifiers.includes("prevent"))
    handler3 = wrapHandler(handler3, (next, e) => {
      e.preventDefault();
      next(e);
    });
  if (modifiers.includes("stop"))
    handler3 = wrapHandler(handler3, (next, e) => {
      e.stopPropagation();
      next(e);
    });
  if (modifiers.includes("self"))
    handler3 = wrapHandler(handler3, (next, e) => {
      e.target === el && next(e);
    });
  if (modifiers.includes("away") || modifiers.includes("outside")) {
    listenerTarget = document;
    handler3 = wrapHandler(handler3, (next, e) => {
      if (el.contains(e.target))
        return;
      if (el.offsetWidth < 1 && el.offsetHeight < 1)
        return;
      if (el._x_isShown === false)
        return;
      next(e);
    });
  }
  handler3 = wrapHandler(handler3, (next, e) => {
    if (isKeyEvent(event)) {
      if (isListeningForASpecificKeyThatHasntBeenPressed(e, modifiers)) {
        return;
      }
    }
    next(e);
  });
  if (modifiers.includes("debounce")) {
    let nextModifier = modifiers[modifiers.indexOf("debounce") + 1] || "invalid-wait";
    let wait = isNumeric(nextModifier.split("ms")[0]) ? Number(nextModifier.split("ms")[0]) : 250;
    handler3 = debounce(handler3, wait);
  }
  if (modifiers.includes("throttle")) {
    let nextModifier = modifiers[modifiers.indexOf("throttle") + 1] || "invalid-wait";
    let wait = isNumeric(nextModifier.split("ms")[0]) ? Number(nextModifier.split("ms")[0]) : 250;
    handler3 = throttle(handler3, wait);
  }
  if (modifiers.includes("once")) {
    handler3 = wrapHandler(handler3, (next, e) => {
      next(e);
      listenerTarget.removeEventListener(event, handler3, options);
    });
  }
  listenerTarget.addEventListener(event, handler3, options);
  return () => {
    listenerTarget.removeEventListener(event, handler3, options);
  };
}
function dotSyntax(subject) {
  return subject.replace(/-/g, ".");
}
function camelCase2(subject) {
  return subject.toLowerCase().replace(/-(\w)/g, (match, char) => char.toUpperCase());
}
function isNumeric(subject) {
  return !Array.isArray(subject) && !isNaN(subject);
}
function kebabCase2(subject) {
  return subject.replace(/([a-z])([A-Z])/g, "$1-$2").replace(/[_\s]/, "-").toLowerCase();
}
function isKeyEvent(event) {
  return ["keydown", "keyup"].includes(event);
}
function isListeningForASpecificKeyThatHasntBeenPressed(e, modifiers) {
  let keyModifiers = modifiers.filter((i) => {
    return !["window", "document", "prevent", "stop", "once"].includes(i);
  });
  if (keyModifiers.includes("debounce")) {
    let debounceIndex = keyModifiers.indexOf("debounce");
    keyModifiers.splice(debounceIndex, isNumeric((keyModifiers[debounceIndex + 1] || "invalid-wait").split("ms")[0]) ? 2 : 1);
  }
  if (keyModifiers.length === 0)
    return false;
  if (keyModifiers.length === 1 && keyToModifiers(e.key).includes(keyModifiers[0]))
    return false;
  const systemKeyModifiers = ["ctrl", "shift", "alt", "meta", "cmd", "super"];
  const selectedSystemKeyModifiers = systemKeyModifiers.filter((modifier) => keyModifiers.includes(modifier));
  keyModifiers = keyModifiers.filter((i) => !selectedSystemKeyModifiers.includes(i));
  if (selectedSystemKeyModifiers.length > 0) {
    const activelyPressedKeyModifiers = selectedSystemKeyModifiers.filter((modifier) => {
      if (modifier === "cmd" || modifier === "super")
        modifier = "meta";
      return e[`${modifier}Key`];
    });
    if (activelyPressedKeyModifiers.length === selectedSystemKeyModifiers.length) {
      if (keyToModifiers(e.key).includes(keyModifiers[0]))
        return false;
    }
  }
  return true;
}
function keyToModifiers(key) {
  if (!key)
    return [];
  key = kebabCase2(key);
  let modifierToKeyMap = {
    ctrl: "control",
    slash: "/",
    space: "-",
    spacebar: "-",
    cmd: "meta",
    esc: "escape",
    up: "arrow-up",
    down: "arrow-down",
    left: "arrow-left",
    right: "arrow-right",
    period: ".",
    equal: "="
  };
  modifierToKeyMap[key] = key;
  return Object.keys(modifierToKeyMap).map((modifier) => {
    if (modifierToKeyMap[modifier] === key)
      return modifier;
  }).filter((modifier) => modifier);
}

// packages/alpinejs/src/directives/x-model.js
directive("model", (el, {modifiers, expression}, {effect: effect3, cleanup}) => {
  let evaluate2 = evaluateLater(el, expression);
  let assignmentExpression = `${expression} = rightSideOfExpression($event, ${expression})`;
  let evaluateAssignment = evaluateLater(el, assignmentExpression);
  var event = el.tagName.toLowerCase() === "select" || ["checkbox", "radio"].includes(el.type) || modifiers.includes("lazy") ? "change" : "input";
  let assigmentFunction = generateAssignmentFunction(el, modifiers, expression);
  let removeListener = on(el, event, modifiers, (e) => {
    evaluateAssignment(() => {
    }, {scope: {
      $event: e,
      rightSideOfExpression: assigmentFunction
    }});
  });
  cleanup(() => removeListener());
  let evaluateSetModel = evaluateLater(el, `${expression} = __placeholder`);
  el._x_model = {
    get() {
      let result;
      evaluate2((value) => result = value);
      return result;
    },
    set(value) {
      evaluateSetModel(() => {
      }, {scope: {__placeholder: value}});
    }
  };
  el._x_forceModelUpdate = () => {
    evaluate2((value) => {
      if (value === void 0 && expression.match(/\./))
        value = "";
      window.fromModel = true;
      mutateDom(() => bind(el, "value", value));
      delete window.fromModel;
    });
  };
  effect3(() => {
    if (modifiers.includes("unintrusive") && document.activeElement.isSameNode(el))
      return;
    el._x_forceModelUpdate();
  });
});
function generateAssignmentFunction(el, modifiers, expression) {
  if (el.type === "radio") {
    mutateDom(() => {
      if (!el.hasAttribute("name"))
        el.setAttribute("name", expression);
    });
  }
  return (event, currentValue) => {
    return mutateDom(() => {
      if (event instanceof CustomEvent && event.detail !== void 0) {
        return event.detail || event.target.value;
      } else if (el.type === "checkbox") {
        if (Array.isArray(currentValue)) {
          let newValue = modifiers.includes("number") ? safeParseNumber(event.target.value) : event.target.value;
          return event.target.checked ? currentValue.concat([newValue]) : currentValue.filter((el2) => !checkedAttrLooseCompare2(el2, newValue));
        } else {
          return event.target.checked;
        }
      } else if (el.tagName.toLowerCase() === "select" && el.multiple) {
        return modifiers.includes("number") ? Array.from(event.target.selectedOptions).map((option) => {
          let rawValue = option.value || option.text;
          return safeParseNumber(rawValue);
        }) : Array.from(event.target.selectedOptions).map((option) => {
          return option.value || option.text;
        });
      } else {
        let rawValue = event.target.value;
        return modifiers.includes("number") ? safeParseNumber(rawValue) : modifiers.includes("trim") ? rawValue.trim() : rawValue;
      }
    });
  };
}
function safeParseNumber(rawValue) {
  let number = rawValue ? parseFloat(rawValue) : null;
  return isNumeric2(number) ? number : rawValue;
}
function checkedAttrLooseCompare2(valueA, valueB) {
  return valueA == valueB;
}
function isNumeric2(subject) {
  return !Array.isArray(subject) && !isNaN(subject);
}

// packages/alpinejs/src/directives/x-cloak.js
directive("cloak", (el) => queueMicrotask(() => mutateDom(() => el.removeAttribute(prefix("cloak")))));

// packages/alpinejs/src/directives/x-init.js
addInitSelector(() => `[${prefix("init")}]`);
directive("init", skipDuringClone((el, {expression}) => {
  if (typeof expression === "string") {
    return !!expression.trim() && evaluate(el, expression, {}, false);
  }
  return evaluate(el, expression, {}, false);
}));

// packages/alpinejs/src/directives/x-text.js
directive("text", (el, {expression}, {effect: effect3, evaluateLater: evaluateLater2}) => {
  let evaluate2 = evaluateLater2(expression);
  effect3(() => {
    evaluate2((value) => {
      mutateDom(() => {
        el.textContent = value;
      });
    });
  });
});

// packages/alpinejs/src/directives/x-html.js
directive("html", (el, {expression}, {effect: effect3, evaluateLater: evaluateLater2}) => {
  let evaluate2 = evaluateLater2(expression);
  effect3(() => {
    evaluate2((value) => {
      el.innerHTML = value;
    });
  });
});

// packages/alpinejs/src/directives/x-bind.js
mapAttributes(startingWith(":", into(prefix("bind:"))));
directive("bind", (el, {value, modifiers, expression, original}, {effect: effect3}) => {
  if (!value)
    return applyBindingsObject(el, expression, original, effect3);
  if (value === "key")
    return storeKeyForXFor(el, expression);
  let evaluate2 = evaluateLater(el, expression);
  effect3(() => evaluate2((result) => {
    if (result === void 0 && expression.match(/\./))
      result = "";
    mutateDom(() => bind(el, value, result, modifiers));
  }));
});
function applyBindingsObject(el, expression, original, effect3) {
  let getBindings = evaluateLater(el, expression);
  let cleanupRunners = [];
  effect3(() => {
    while (cleanupRunners.length)
      cleanupRunners.pop()();
    getBindings((bindings) => {
      let attributes = Object.entries(bindings).map(([name, value]) => ({name, value}));
      let staticAttributes = attributesOnly(attributes);
      attributes = attributes.map((attribute) => {
        if (staticAttributes.find((attr) => attr.name === attribute.name)) {
          return {
            name: `x-bind:${attribute.name}`,
            value: `"${attribute.value}"`
          };
        }
        return attribute;
      });
      directives(el, attributes, original).map((handle) => {
        cleanupRunners.push(handle.runCleanups);
        handle();
      });
    });
  });
}
function storeKeyForXFor(el, expression) {
  el._x_keyExpression = expression;
}

// packages/alpinejs/src/directives/x-data.js
addRootSelector(() => `[${prefix("data")}]`);
directive("data", skipDuringClone((el, {expression}, {cleanup}) => {
  expression = expression === "" ? "{}" : expression;
  let magicContext = {};
  injectMagics(magicContext, el);
  let dataProviderContext = {};
  injectDataProviders(dataProviderContext, magicContext);
  let data2 = evaluate(el, expression, {scope: dataProviderContext});
  if (data2 === void 0)
    data2 = {};
  injectMagics(data2, el);
  let reactiveData = reactive(data2);
  initInterceptors(reactiveData);
  let undo = addScopeToNode(el, reactiveData);
  reactiveData["init"] && evaluate(el, reactiveData["init"]);
  cleanup(() => {
    undo();
    reactiveData["destroy"] && evaluate(el, reactiveData["destroy"]);
  });
}));

// packages/alpinejs/src/directives/x-show.js
directive("show", (el, {modifiers, expression}, {effect: effect3}) => {
  let evaluate2 = evaluateLater(el, expression);
  let hide = () => mutateDom(() => {
    el.style.display = "none";
    el._x_isShown = false;
  });
  let show = () => mutateDom(() => {
    if (el.style.length === 1 && el.style.display === "none") {
      el.removeAttribute("style");
    } else {
      el.style.removeProperty("display");
    }
    el._x_isShown = true;
  });
  let clickAwayCompatibleShow = () => setTimeout(show);
  let toggle = once((value) => value ? show() : hide(), (value) => {
    if (typeof el._x_toggleAndCascadeWithTransitions === "function") {
      el._x_toggleAndCascadeWithTransitions(el, value, show, hide);
    } else {
      value ? clickAwayCompatibleShow() : hide();
    }
  });
  let oldValue;
  let firstTime = true;
  effect3(() => evaluate2((value) => {
    if (!firstTime && value === oldValue)
      return;
    if (modifiers.includes("immediate"))
      value ? clickAwayCompatibleShow() : hide();
    toggle(value);
    oldValue = value;
    firstTime = false;
  }));
});

// packages/alpinejs/src/directives/x-for.js
directive("for", (el, {expression}, {effect: effect3, cleanup}) => {
  let iteratorNames = parseForExpression(expression);
  let evaluateItems = evaluateLater(el, iteratorNames.items);
  let evaluateKey = evaluateLater(el, el._x_keyExpression || "index");
  el._x_prevKeys = [];
  el._x_lookup = {};
  effect3(() => loop(el, iteratorNames, evaluateItems, evaluateKey));
  cleanup(() => {
    Object.values(el._x_lookup).forEach((el2) => el2.remove());
    delete el._x_prevKeys;
    delete el._x_lookup;
  });
});
function loop(el, iteratorNames, evaluateItems, evaluateKey) {
  let isObject = (i) => typeof i === "object" && !Array.isArray(i);
  let templateEl = el;
  evaluateItems((items) => {
    if (isNumeric3(items) && items >= 0) {
      items = Array.from(Array(items).keys(), (i) => i + 1);
    }
    if (items === void 0)
      items = [];
    let lookup = el._x_lookup;
    let prevKeys = el._x_prevKeys;
    let scopes = [];
    let keys = [];
    if (isObject(items)) {
      items = Object.entries(items).map(([key, value]) => {
        let scope = getIterationScopeVariables(iteratorNames, value, key, items);
        evaluateKey((value2) => keys.push(value2), {scope: {index: key, ...scope}});
        scopes.push(scope);
      });
    } else {
      for (let i = 0; i < items.length; i++) {
        let scope = getIterationScopeVariables(iteratorNames, items[i], i, items);
        evaluateKey((value) => keys.push(value), {scope: {index: i, ...scope}});
        scopes.push(scope);
      }
    }
    let adds = [];
    let moves = [];
    let removes = [];
    let sames = [];
    for (let i = 0; i < prevKeys.length; i++) {
      let key = prevKeys[i];
      if (keys.indexOf(key) === -1)
        removes.push(key);
    }
    prevKeys = prevKeys.filter((key) => !removes.includes(key));
    let lastKey = "template";
    for (let i = 0; i < keys.length; i++) {
      let key = keys[i];
      let prevIndex = prevKeys.indexOf(key);
      if (prevIndex === -1) {
        prevKeys.splice(i, 0, key);
        adds.push([lastKey, i]);
      } else if (prevIndex !== i) {
        let keyInSpot = prevKeys.splice(i, 1)[0];
        let keyForSpot = prevKeys.splice(prevIndex - 1, 1)[0];
        prevKeys.splice(i, 0, keyForSpot);
        prevKeys.splice(prevIndex, 0, keyInSpot);
        moves.push([keyInSpot, keyForSpot]);
      } else {
        sames.push(key);
      }
      lastKey = key;
    }
    for (let i = 0; i < removes.length; i++) {
      let key = removes[i];
      lookup[key].remove();
      lookup[key] = null;
      delete lookup[key];
    }
    for (let i = 0; i < moves.length; i++) {
      let [keyInSpot, keyForSpot] = moves[i];
      let elInSpot = lookup[keyInSpot];
      let elForSpot = lookup[keyForSpot];
      let marker = document.createElement("div");
      mutateDom(() => {
        elForSpot.after(marker);
        elInSpot.after(elForSpot);
        elForSpot._x_currentIfEl && elForSpot.after(elForSpot._x_currentIfEl);
        marker.before(elInSpot);
        elInSpot._x_currentIfEl && elInSpot.after(elInSpot._x_currentIfEl);
        marker.remove();
      });
      refreshScope(elForSpot, scopes[keys.indexOf(keyForSpot)]);
    }
    for (let i = 0; i < adds.length; i++) {
      let [lastKey2, index] = adds[i];
      let lastEl = lastKey2 === "template" ? templateEl : lookup[lastKey2];
      if (lastEl._x_currentIfEl)
        lastEl = lastEl._x_currentIfEl;
      let scope = scopes[index];
      let key = keys[index];
      let clone2 = document.importNode(templateEl.content, true).firstElementChild;
      addScopeToNode(clone2, reactive(scope), templateEl);
      mutateDom(() => {
        lastEl.after(clone2);
        initTree(clone2);
      });
      if (typeof key === "object") {
        warn("x-for key cannot be an object, it must be a string or an integer", templateEl);
      }
      lookup[key] = clone2;
    }
    for (let i = 0; i < sames.length; i++) {
      refreshScope(lookup[sames[i]], scopes[keys.indexOf(sames[i])]);
    }
    templateEl._x_prevKeys = keys;
  });
}
function parseForExpression(expression) {
  let forIteratorRE = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/;
  let stripParensRE = /^\s*\(|\)\s*$/g;
  let forAliasRE = /([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/;
  let inMatch = expression.match(forAliasRE);
  if (!inMatch)
    return;
  let res = {};
  res.items = inMatch[2].trim();
  let item = inMatch[1].replace(stripParensRE, "").trim();
  let iteratorMatch = item.match(forIteratorRE);
  if (iteratorMatch) {
    res.item = item.replace(forIteratorRE, "").trim();
    res.index = iteratorMatch[1].trim();
    if (iteratorMatch[2]) {
      res.collection = iteratorMatch[2].trim();
    }
  } else {
    res.item = item;
  }
  return res;
}
function getIterationScopeVariables(iteratorNames, item, index, items) {
  let scopeVariables = {};
  if (/^\[.*\]$/.test(iteratorNames.item) && Array.isArray(item)) {
    let names = iteratorNames.item.replace("[", "").replace("]", "").split(",").map((i) => i.trim());
    names.forEach((name, i) => {
      scopeVariables[name] = item[i];
    });
  } else if (/^\{.*\}$/.test(iteratorNames.item) && !Array.isArray(item) && typeof item === "object") {
    let names = iteratorNames.item.replace("{", "").replace("}", "").split(",").map((i) => i.trim());
    names.forEach((name) => {
      scopeVariables[name] = item[name];
    });
  } else {
    scopeVariables[iteratorNames.item] = item;
  }
  if (iteratorNames.index)
    scopeVariables[iteratorNames.index] = index;
  if (iteratorNames.collection)
    scopeVariables[iteratorNames.collection] = items;
  return scopeVariables;
}
function isNumeric3(subject) {
  return !Array.isArray(subject) && !isNaN(subject);
}

// packages/alpinejs/src/directives/x-ref.js
function handler2() {
}
handler2.inline = (el, {expression}, {cleanup}) => {
  let root = closestRoot(el);
  if (!root._x_refs)
    root._x_refs = {};
  root._x_refs[expression] = el;
  cleanup(() => delete root._x_refs[expression]);
};
directive("ref", handler2);

// packages/alpinejs/src/directives/x-if.js
directive("if", (el, {expression}, {effect: effect3, cleanup}) => {
  let evaluate2 = evaluateLater(el, expression);
  let show = () => {
    if (el._x_currentIfEl)
      return el._x_currentIfEl;
    let clone2 = el.content.cloneNode(true).firstElementChild;
    addScopeToNode(clone2, {}, el);
    mutateDom(() => {
      el.after(clone2);
      initTree(clone2);
    });
    el._x_currentIfEl = clone2;
    el._x_undoIf = () => {
      clone2.remove();
      delete el._x_currentIfEl;
    };
    return clone2;
  };
  let hide = () => {
    if (!el._x_undoIf)
      return;
    el._x_undoIf();
    delete el._x_undoIf;
  };
  effect3(() => evaluate2((value) => {
    value ? show() : hide();
  }));
  cleanup(() => el._x_undoIf && el._x_undoIf());
});

// packages/alpinejs/src/directives/x-id.js
directive("id", (el, {expression}, {evaluate: evaluate2}) => {
  let names = evaluate2(expression);
  names.forEach((name) => setIdRoot(el, name));
});

// packages/alpinejs/src/directives/x-on.js
mapAttributes(startingWith("@", into(prefix("on:"))));
directive("on", skipDuringClone((el, {value, modifiers, expression}, {cleanup}) => {
  let evaluate2 = expression ? evaluateLater(el, expression) : () => {
  };
  if (el.tagName.toLowerCase() === "template") {
    if (!el._x_forwardEvents)
      el._x_forwardEvents = [];
    if (!el._x_forwardEvents.includes(value))
      el._x_forwardEvents.push(value);
  }
  let removeListener = on(el, value, modifiers, (e) => {
    evaluate2(() => {
    }, {scope: {$event: e}, params: [e]});
  });
  cleanup(() => removeListener());
}));

// packages/alpinejs/src/index.js
alpine_default.setEvaluator(normalEvaluator);
alpine_default.setReactivityEngine({reactive: import_reactivity9.reactive, effect: import_reactivity9.effect, release: import_reactivity9.stop, raw: import_reactivity9.toRaw});
var src_default = alpine_default;

// packages/alpinejs/builds/module.js
var module_default = src_default;



/***/ }),

/***/ "./node_modules/axios/index.js":
/*!*************************************!*\
  !*** ./node_modules/axios/index.js ***!
  \*************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__(/*! ./lib/axios */ "./node_modules/axios/lib/axios.js");

/***/ }),

/***/ "./node_modules/axios/lib/adapters/xhr.js":
/*!************************************************!*\
  !*** ./node_modules/axios/lib/adapters/xhr.js ***!
  \************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var settle = __webpack_require__(/*! ./../core/settle */ "./node_modules/axios/lib/core/settle.js");
var cookies = __webpack_require__(/*! ./../helpers/cookies */ "./node_modules/axios/lib/helpers/cookies.js");
var buildURL = __webpack_require__(/*! ./../helpers/buildURL */ "./node_modules/axios/lib/helpers/buildURL.js");
var buildFullPath = __webpack_require__(/*! ../core/buildFullPath */ "./node_modules/axios/lib/core/buildFullPath.js");
var parseHeaders = __webpack_require__(/*! ./../helpers/parseHeaders */ "./node_modules/axios/lib/helpers/parseHeaders.js");
var isURLSameOrigin = __webpack_require__(/*! ./../helpers/isURLSameOrigin */ "./node_modules/axios/lib/helpers/isURLSameOrigin.js");
var createError = __webpack_require__(/*! ../core/createError */ "./node_modules/axios/lib/core/createError.js");
var defaults = __webpack_require__(/*! ../defaults */ "./node_modules/axios/lib/defaults.js");
var Cancel = __webpack_require__(/*! ../cancel/Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");

module.exports = function xhrAdapter(config) {
  return new Promise(function dispatchXhrRequest(resolve, reject) {
    var requestData = config.data;
    var requestHeaders = config.headers;
    var responseType = config.responseType;
    var onCanceled;
    function done() {
      if (config.cancelToken) {
        config.cancelToken.unsubscribe(onCanceled);
      }

      if (config.signal) {
        config.signal.removeEventListener('abort', onCanceled);
      }
    }

    if (utils.isFormData(requestData)) {
      delete requestHeaders['Content-Type']; // Let the browser set it
    }

    var request = new XMLHttpRequest();

    // HTTP basic authentication
    if (config.auth) {
      var username = config.auth.username || '';
      var password = config.auth.password ? unescape(encodeURIComponent(config.auth.password)) : '';
      requestHeaders.Authorization = 'Basic ' + btoa(username + ':' + password);
    }

    var fullPath = buildFullPath(config.baseURL, config.url);
    request.open(config.method.toUpperCase(), buildURL(fullPath, config.params, config.paramsSerializer), true);

    // Set the request timeout in MS
    request.timeout = config.timeout;

    function onloadend() {
      if (!request) {
        return;
      }
      // Prepare the response
      var responseHeaders = 'getAllResponseHeaders' in request ? parseHeaders(request.getAllResponseHeaders()) : null;
      var responseData = !responseType || responseType === 'text' ||  responseType === 'json' ?
        request.responseText : request.response;
      var response = {
        data: responseData,
        status: request.status,
        statusText: request.statusText,
        headers: responseHeaders,
        config: config,
        request: request
      };

      settle(function _resolve(value) {
        resolve(value);
        done();
      }, function _reject(err) {
        reject(err);
        done();
      }, response);

      // Clean up request
      request = null;
    }

    if ('onloadend' in request) {
      // Use onloadend if available
      request.onloadend = onloadend;
    } else {
      // Listen for ready state to emulate onloadend
      request.onreadystatechange = function handleLoad() {
        if (!request || request.readyState !== 4) {
          return;
        }

        // The request errored out and we didn't get a response, this will be
        // handled by onerror instead
        // With one exception: request that using file: protocol, most browsers
        // will return status as 0 even though it's a successful request
        if (request.status === 0 && !(request.responseURL && request.responseURL.indexOf('file:') === 0)) {
          return;
        }
        // readystate handler is calling before onerror or ontimeout handlers,
        // so we should call onloadend on the next 'tick'
        setTimeout(onloadend);
      };
    }

    // Handle browser request cancellation (as opposed to a manual cancellation)
    request.onabort = function handleAbort() {
      if (!request) {
        return;
      }

      reject(createError('Request aborted', config, 'ECONNABORTED', request));

      // Clean up request
      request = null;
    };

    // Handle low level network errors
    request.onerror = function handleError() {
      // Real errors are hidden from us by the browser
      // onerror should only fire if it's a network error
      reject(createError('Network Error', config, null, request));

      // Clean up request
      request = null;
    };

    // Handle timeout
    request.ontimeout = function handleTimeout() {
      var timeoutErrorMessage = config.timeout ? 'timeout of ' + config.timeout + 'ms exceeded' : 'timeout exceeded';
      var transitional = config.transitional || defaults.transitional;
      if (config.timeoutErrorMessage) {
        timeoutErrorMessage = config.timeoutErrorMessage;
      }
      reject(createError(
        timeoutErrorMessage,
        config,
        transitional.clarifyTimeoutError ? 'ETIMEDOUT' : 'ECONNABORTED',
        request));

      // Clean up request
      request = null;
    };

    // Add xsrf header
    // This is only done if running in a standard browser environment.
    // Specifically not if we're in a web worker, or react-native.
    if (utils.isStandardBrowserEnv()) {
      // Add xsrf header
      var xsrfValue = (config.withCredentials || isURLSameOrigin(fullPath)) && config.xsrfCookieName ?
        cookies.read(config.xsrfCookieName) :
        undefined;

      if (xsrfValue) {
        requestHeaders[config.xsrfHeaderName] = xsrfValue;
      }
    }

    // Add headers to the request
    if ('setRequestHeader' in request) {
      utils.forEach(requestHeaders, function setRequestHeader(val, key) {
        if (typeof requestData === 'undefined' && key.toLowerCase() === 'content-type') {
          // Remove Content-Type if data is undefined
          delete requestHeaders[key];
        } else {
          // Otherwise add header to the request
          request.setRequestHeader(key, val);
        }
      });
    }

    // Add withCredentials to request if needed
    if (!utils.isUndefined(config.withCredentials)) {
      request.withCredentials = !!config.withCredentials;
    }

    // Add responseType to request if needed
    if (responseType && responseType !== 'json') {
      request.responseType = config.responseType;
    }

    // Handle progress if needed
    if (typeof config.onDownloadProgress === 'function') {
      request.addEventListener('progress', config.onDownloadProgress);
    }

    // Not all browsers support upload events
    if (typeof config.onUploadProgress === 'function' && request.upload) {
      request.upload.addEventListener('progress', config.onUploadProgress);
    }

    if (config.cancelToken || config.signal) {
      // Handle cancellation
      // eslint-disable-next-line func-names
      onCanceled = function(cancel) {
        if (!request) {
          return;
        }
        reject(!cancel || (cancel && cancel.type) ? new Cancel('canceled') : cancel);
        request.abort();
        request = null;
      };

      config.cancelToken && config.cancelToken.subscribe(onCanceled);
      if (config.signal) {
        config.signal.aborted ? onCanceled() : config.signal.addEventListener('abort', onCanceled);
      }
    }

    if (!requestData) {
      requestData = null;
    }

    // Send the request
    request.send(requestData);
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/axios.js":
/*!*****************************************!*\
  !*** ./node_modules/axios/lib/axios.js ***!
  \*****************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");
var Axios = __webpack_require__(/*! ./core/Axios */ "./node_modules/axios/lib/core/Axios.js");
var mergeConfig = __webpack_require__(/*! ./core/mergeConfig */ "./node_modules/axios/lib/core/mergeConfig.js");
var defaults = __webpack_require__(/*! ./defaults */ "./node_modules/axios/lib/defaults.js");

/**
 * Create an instance of Axios
 *
 * @param {Object} defaultConfig The default config for the instance
 * @return {Axios} A new instance of Axios
 */
function createInstance(defaultConfig) {
  var context = new Axios(defaultConfig);
  var instance = bind(Axios.prototype.request, context);

  // Copy axios.prototype to instance
  utils.extend(instance, Axios.prototype, context);

  // Copy context to instance
  utils.extend(instance, context);

  // Factory for creating new instances
  instance.create = function create(instanceConfig) {
    return createInstance(mergeConfig(defaultConfig, instanceConfig));
  };

  return instance;
}

// Create the default instance to be exported
var axios = createInstance(defaults);

// Expose Axios class to allow class inheritance
axios.Axios = Axios;

// Expose Cancel & CancelToken
axios.Cancel = __webpack_require__(/*! ./cancel/Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");
axios.CancelToken = __webpack_require__(/*! ./cancel/CancelToken */ "./node_modules/axios/lib/cancel/CancelToken.js");
axios.isCancel = __webpack_require__(/*! ./cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");
axios.VERSION = (__webpack_require__(/*! ./env/data */ "./node_modules/axios/lib/env/data.js").version);

// Expose all/spread
axios.all = function all(promises) {
  return Promise.all(promises);
};
axios.spread = __webpack_require__(/*! ./helpers/spread */ "./node_modules/axios/lib/helpers/spread.js");

// Expose isAxiosError
axios.isAxiosError = __webpack_require__(/*! ./helpers/isAxiosError */ "./node_modules/axios/lib/helpers/isAxiosError.js");

module.exports = axios;

// Allow use of default import syntax in TypeScript
module.exports["default"] = axios;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/Cancel.js":
/*!*************************************************!*\
  !*** ./node_modules/axios/lib/cancel/Cancel.js ***!
  \*************************************************/
/***/ ((module) => {

"use strict";


/**
 * A `Cancel` is an object that is thrown when an operation is canceled.
 *
 * @class
 * @param {string=} message The message.
 */
function Cancel(message) {
  this.message = message;
}

Cancel.prototype.toString = function toString() {
  return 'Cancel' + (this.message ? ': ' + this.message : '');
};

Cancel.prototype.__CANCEL__ = true;

module.exports = Cancel;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/CancelToken.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/cancel/CancelToken.js ***!
  \******************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var Cancel = __webpack_require__(/*! ./Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");

/**
 * A `CancelToken` is an object that can be used to request cancellation of an operation.
 *
 * @class
 * @param {Function} executor The executor function.
 */
function CancelToken(executor) {
  if (typeof executor !== 'function') {
    throw new TypeError('executor must be a function.');
  }

  var resolvePromise;

  this.promise = new Promise(function promiseExecutor(resolve) {
    resolvePromise = resolve;
  });

  var token = this;

  // eslint-disable-next-line func-names
  this.promise.then(function(cancel) {
    if (!token._listeners) return;

    var i;
    var l = token._listeners.length;

    for (i = 0; i < l; i++) {
      token._listeners[i](cancel);
    }
    token._listeners = null;
  });

  // eslint-disable-next-line func-names
  this.promise.then = function(onfulfilled) {
    var _resolve;
    // eslint-disable-next-line func-names
    var promise = new Promise(function(resolve) {
      token.subscribe(resolve);
      _resolve = resolve;
    }).then(onfulfilled);

    promise.cancel = function reject() {
      token.unsubscribe(_resolve);
    };

    return promise;
  };

  executor(function cancel(message) {
    if (token.reason) {
      // Cancellation has already been requested
      return;
    }

    token.reason = new Cancel(message);
    resolvePromise(token.reason);
  });
}

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
CancelToken.prototype.throwIfRequested = function throwIfRequested() {
  if (this.reason) {
    throw this.reason;
  }
};

/**
 * Subscribe to the cancel signal
 */

CancelToken.prototype.subscribe = function subscribe(listener) {
  if (this.reason) {
    listener(this.reason);
    return;
  }

  if (this._listeners) {
    this._listeners.push(listener);
  } else {
    this._listeners = [listener];
  }
};

/**
 * Unsubscribe from the cancel signal
 */

CancelToken.prototype.unsubscribe = function unsubscribe(listener) {
  if (!this._listeners) {
    return;
  }
  var index = this._listeners.indexOf(listener);
  if (index !== -1) {
    this._listeners.splice(index, 1);
  }
};

/**
 * Returns an object that contains a new `CancelToken` and a function that, when called,
 * cancels the `CancelToken`.
 */
CancelToken.source = function source() {
  var cancel;
  var token = new CancelToken(function executor(c) {
    cancel = c;
  });
  return {
    token: token,
    cancel: cancel
  };
};

module.exports = CancelToken;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/isCancel.js":
/*!***************************************************!*\
  !*** ./node_modules/axios/lib/cancel/isCancel.js ***!
  \***************************************************/
/***/ ((module) => {

"use strict";


module.exports = function isCancel(value) {
  return !!(value && value.__CANCEL__);
};


/***/ }),

/***/ "./node_modules/axios/lib/core/Axios.js":
/*!**********************************************!*\
  !*** ./node_modules/axios/lib/core/Axios.js ***!
  \**********************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var buildURL = __webpack_require__(/*! ../helpers/buildURL */ "./node_modules/axios/lib/helpers/buildURL.js");
var InterceptorManager = __webpack_require__(/*! ./InterceptorManager */ "./node_modules/axios/lib/core/InterceptorManager.js");
var dispatchRequest = __webpack_require__(/*! ./dispatchRequest */ "./node_modules/axios/lib/core/dispatchRequest.js");
var mergeConfig = __webpack_require__(/*! ./mergeConfig */ "./node_modules/axios/lib/core/mergeConfig.js");
var validator = __webpack_require__(/*! ../helpers/validator */ "./node_modules/axios/lib/helpers/validator.js");

var validators = validator.validators;
/**
 * Create a new instance of Axios
 *
 * @param {Object} instanceConfig The default config for the instance
 */
function Axios(instanceConfig) {
  this.defaults = instanceConfig;
  this.interceptors = {
    request: new InterceptorManager(),
    response: new InterceptorManager()
  };
}

/**
 * Dispatch a request
 *
 * @param {Object} config The config specific for this request (merged with this.defaults)
 */
Axios.prototype.request = function request(config) {
  /*eslint no-param-reassign:0*/
  // Allow for axios('example/url'[, config]) a la fetch API
  if (typeof config === 'string') {
    config = arguments[1] || {};
    config.url = arguments[0];
  } else {
    config = config || {};
  }

  config = mergeConfig(this.defaults, config);

  // Set config.method
  if (config.method) {
    config.method = config.method.toLowerCase();
  } else if (this.defaults.method) {
    config.method = this.defaults.method.toLowerCase();
  } else {
    config.method = 'get';
  }

  var transitional = config.transitional;

  if (transitional !== undefined) {
    validator.assertOptions(transitional, {
      silentJSONParsing: validators.transitional(validators.boolean),
      forcedJSONParsing: validators.transitional(validators.boolean),
      clarifyTimeoutError: validators.transitional(validators.boolean)
    }, false);
  }

  // filter out skipped interceptors
  var requestInterceptorChain = [];
  var synchronousRequestInterceptors = true;
  this.interceptors.request.forEach(function unshiftRequestInterceptors(interceptor) {
    if (typeof interceptor.runWhen === 'function' && interceptor.runWhen(config) === false) {
      return;
    }

    synchronousRequestInterceptors = synchronousRequestInterceptors && interceptor.synchronous;

    requestInterceptorChain.unshift(interceptor.fulfilled, interceptor.rejected);
  });

  var responseInterceptorChain = [];
  this.interceptors.response.forEach(function pushResponseInterceptors(interceptor) {
    responseInterceptorChain.push(interceptor.fulfilled, interceptor.rejected);
  });

  var promise;

  if (!synchronousRequestInterceptors) {
    var chain = [dispatchRequest, undefined];

    Array.prototype.unshift.apply(chain, requestInterceptorChain);
    chain = chain.concat(responseInterceptorChain);

    promise = Promise.resolve(config);
    while (chain.length) {
      promise = promise.then(chain.shift(), chain.shift());
    }

    return promise;
  }


  var newConfig = config;
  while (requestInterceptorChain.length) {
    var onFulfilled = requestInterceptorChain.shift();
    var onRejected = requestInterceptorChain.shift();
    try {
      newConfig = onFulfilled(newConfig);
    } catch (error) {
      onRejected(error);
      break;
    }
  }

  try {
    promise = dispatchRequest(newConfig);
  } catch (error) {
    return Promise.reject(error);
  }

  while (responseInterceptorChain.length) {
    promise = promise.then(responseInterceptorChain.shift(), responseInterceptorChain.shift());
  }

  return promise;
};

Axios.prototype.getUri = function getUri(config) {
  config = mergeConfig(this.defaults, config);
  return buildURL(config.url, config.params, config.paramsSerializer).replace(/^\?/, '');
};

// Provide aliases for supported request methods
utils.forEach(['delete', 'get', 'head', 'options'], function forEachMethodNoData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, config) {
    return this.request(mergeConfig(config || {}, {
      method: method,
      url: url,
      data: (config || {}).data
    }));
  };
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, data, config) {
    return this.request(mergeConfig(config || {}, {
      method: method,
      url: url,
      data: data
    }));
  };
});

module.exports = Axios;


/***/ }),

/***/ "./node_modules/axios/lib/core/InterceptorManager.js":
/*!***********************************************************!*\
  !*** ./node_modules/axios/lib/core/InterceptorManager.js ***!
  \***********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

function InterceptorManager() {
  this.handlers = [];
}

/**
 * Add a new interceptor to the stack
 *
 * @param {Function} fulfilled The function to handle `then` for a `Promise`
 * @param {Function} rejected The function to handle `reject` for a `Promise`
 *
 * @return {Number} An ID used to remove interceptor later
 */
InterceptorManager.prototype.use = function use(fulfilled, rejected, options) {
  this.handlers.push({
    fulfilled: fulfilled,
    rejected: rejected,
    synchronous: options ? options.synchronous : false,
    runWhen: options ? options.runWhen : null
  });
  return this.handlers.length - 1;
};

/**
 * Remove an interceptor from the stack
 *
 * @param {Number} id The ID that was returned by `use`
 */
InterceptorManager.prototype.eject = function eject(id) {
  if (this.handlers[id]) {
    this.handlers[id] = null;
  }
};

/**
 * Iterate over all the registered interceptors
 *
 * This method is particularly useful for skipping over any
 * interceptors that may have become `null` calling `eject`.
 *
 * @param {Function} fn The function to call for each interceptor
 */
InterceptorManager.prototype.forEach = function forEach(fn) {
  utils.forEach(this.handlers, function forEachHandler(h) {
    if (h !== null) {
      fn(h);
    }
  });
};

module.exports = InterceptorManager;


/***/ }),

/***/ "./node_modules/axios/lib/core/buildFullPath.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/core/buildFullPath.js ***!
  \******************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var isAbsoluteURL = __webpack_require__(/*! ../helpers/isAbsoluteURL */ "./node_modules/axios/lib/helpers/isAbsoluteURL.js");
var combineURLs = __webpack_require__(/*! ../helpers/combineURLs */ "./node_modules/axios/lib/helpers/combineURLs.js");

/**
 * Creates a new URL by combining the baseURL with the requestedURL,
 * only when the requestedURL is not already an absolute URL.
 * If the requestURL is absolute, this function returns the requestedURL untouched.
 *
 * @param {string} baseURL The base URL
 * @param {string} requestedURL Absolute or relative URL to combine
 * @returns {string} The combined full path
 */
module.exports = function buildFullPath(baseURL, requestedURL) {
  if (baseURL && !isAbsoluteURL(requestedURL)) {
    return combineURLs(baseURL, requestedURL);
  }
  return requestedURL;
};


/***/ }),

/***/ "./node_modules/axios/lib/core/createError.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/core/createError.js ***!
  \****************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var enhanceError = __webpack_require__(/*! ./enhanceError */ "./node_modules/axios/lib/core/enhanceError.js");

/**
 * Create an Error with the specified message, config, error code, request and response.
 *
 * @param {string} message The error message.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The created error.
 */
module.exports = function createError(message, config, code, request, response) {
  var error = new Error(message);
  return enhanceError(error, config, code, request, response);
};


/***/ }),

/***/ "./node_modules/axios/lib/core/dispatchRequest.js":
/*!********************************************************!*\
  !*** ./node_modules/axios/lib/core/dispatchRequest.js ***!
  \********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var transformData = __webpack_require__(/*! ./transformData */ "./node_modules/axios/lib/core/transformData.js");
var isCancel = __webpack_require__(/*! ../cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");
var defaults = __webpack_require__(/*! ../defaults */ "./node_modules/axios/lib/defaults.js");
var Cancel = __webpack_require__(/*! ../cancel/Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
function throwIfCancellationRequested(config) {
  if (config.cancelToken) {
    config.cancelToken.throwIfRequested();
  }

  if (config.signal && config.signal.aborted) {
    throw new Cancel('canceled');
  }
}

/**
 * Dispatch a request to the server using the configured adapter.
 *
 * @param {object} config The config that is to be used for the request
 * @returns {Promise} The Promise to be fulfilled
 */
module.exports = function dispatchRequest(config) {
  throwIfCancellationRequested(config);

  // Ensure headers exist
  config.headers = config.headers || {};

  // Transform request data
  config.data = transformData.call(
    config,
    config.data,
    config.headers,
    config.transformRequest
  );

  // Flatten headers
  config.headers = utils.merge(
    config.headers.common || {},
    config.headers[config.method] || {},
    config.headers
  );

  utils.forEach(
    ['delete', 'get', 'head', 'post', 'put', 'patch', 'common'],
    function cleanHeaderConfig(method) {
      delete config.headers[method];
    }
  );

  var adapter = config.adapter || defaults.adapter;

  return adapter(config).then(function onAdapterResolution(response) {
    throwIfCancellationRequested(config);

    // Transform response data
    response.data = transformData.call(
      config,
      response.data,
      response.headers,
      config.transformResponse
    );

    return response;
  }, function onAdapterRejection(reason) {
    if (!isCancel(reason)) {
      throwIfCancellationRequested(config);

      // Transform response data
      if (reason && reason.response) {
        reason.response.data = transformData.call(
          config,
          reason.response.data,
          reason.response.headers,
          config.transformResponse
        );
      }
    }

    return Promise.reject(reason);
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/core/enhanceError.js":
/*!*****************************************************!*\
  !*** ./node_modules/axios/lib/core/enhanceError.js ***!
  \*****************************************************/
/***/ ((module) => {

"use strict";


/**
 * Update an Error with the specified config, error code, and response.
 *
 * @param {Error} error The error to update.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The error.
 */
module.exports = function enhanceError(error, config, code, request, response) {
  error.config = config;
  if (code) {
    error.code = code;
  }

  error.request = request;
  error.response = response;
  error.isAxiosError = true;

  error.toJSON = function toJSON() {
    return {
      // Standard
      message: this.message,
      name: this.name,
      // Microsoft
      description: this.description,
      number: this.number,
      // Mozilla
      fileName: this.fileName,
      lineNumber: this.lineNumber,
      columnNumber: this.columnNumber,
      stack: this.stack,
      // Axios
      config: this.config,
      code: this.code,
      status: this.response && this.response.status ? this.response.status : null
    };
  };
  return error;
};


/***/ }),

/***/ "./node_modules/axios/lib/core/mergeConfig.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/core/mergeConfig.js ***!
  \****************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var utils = __webpack_require__(/*! ../utils */ "./node_modules/axios/lib/utils.js");

/**
 * Config-specific merge-function which creates a new config-object
 * by merging two configuration objects together.
 *
 * @param {Object} config1
 * @param {Object} config2
 * @returns {Object} New object resulting from merging config2 to config1
 */
module.exports = function mergeConfig(config1, config2) {
  // eslint-disable-next-line no-param-reassign
  config2 = config2 || {};
  var config = {};

  function getMergedValue(target, source) {
    if (utils.isPlainObject(target) && utils.isPlainObject(source)) {
      return utils.merge(target, source);
    } else if (utils.isPlainObject(source)) {
      return utils.merge({}, source);
    } else if (utils.isArray(source)) {
      return source.slice();
    }
    return source;
  }

  // eslint-disable-next-line consistent-return
  function mergeDeepProperties(prop) {
    if (!utils.isUndefined(config2[prop])) {
      return getMergedValue(config1[prop], config2[prop]);
    } else if (!utils.isUndefined(config1[prop])) {
      return getMergedValue(undefined, config1[prop]);
    }
  }

  // eslint-disable-next-line consistent-return
  function valueFromConfig2(prop) {
    if (!utils.isUndefined(config2[prop])) {
      return getMergedValue(undefined, config2[prop]);
    }
  }

  // eslint-disable-next-line consistent-return
  function defaultToConfig2(prop) {
    if (!utils.isUndefined(config2[prop])) {
      return getMergedValue(undefined, config2[prop]);
    } else if (!utils.isUndefined(config1[prop])) {
      return getMergedValue(undefined, config1[prop]);
    }
  }

  // eslint-disable-next-line consistent-return
  function mergeDirectKeys(prop) {
    if (prop in config2) {
      return getMergedValue(config1[prop], config2[prop]);
    } else if (prop in config1) {
      return getMergedValue(undefined, config1[prop]);
    }
  }

  var mergeMap = {
    'url': valueFromConfig2,
    'method': valueFromConfig2,
    'data': valueFromConfig2,
    'baseURL': defaultToConfig2,
    'transformRequest': defaultToConfig2,
    'transformResponse': defaultToConfig2,
    'paramsSerializer': defaultToConfig2,
    'timeout': defaultToConfig2,
    'timeoutMessage': defaultToConfig2,
    'withCredentials': defaultToConfig2,
    'adapter': defaultToConfig2,
    'responseType': defaultToConfig2,
    'xsrfCookieName': defaultToConfig2,
    'xsrfHeaderName': defaultToConfig2,
    'onUploadProgress': defaultToConfig2,
    'onDownloadProgress': defaultToConfig2,
    'decompress': defaultToConfig2,
    'maxContentLength': defaultToConfig2,
    'maxBodyLength': defaultToConfig2,
    'transport': defaultToConfig2,
    'httpAgent': defaultToConfig2,
    'httpsAgent': defaultToConfig2,
    'cancelToken': defaultToConfig2,
    'socketPath': defaultToConfig2,
    'responseEncoding': defaultToConfig2,
    'validateStatus': mergeDirectKeys
  };

  utils.forEach(Object.keys(config1).concat(Object.keys(config2)), function computeConfigValue(prop) {
    var merge = mergeMap[prop] || mergeDeepProperties;
    var configValue = merge(prop);
    (utils.isUndefined(configValue) && merge !== mergeDirectKeys) || (config[prop] = configValue);
  });

  return config;
};


/***/ }),

/***/ "./node_modules/axios/lib/core/settle.js":
/*!***********************************************!*\
  !*** ./node_modules/axios/lib/core/settle.js ***!
  \***********************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var createError = __webpack_require__(/*! ./createError */ "./node_modules/axios/lib/core/createError.js");

/**
 * Resolve or reject a Promise based on response status.
 *
 * @param {Function} resolve A function that resolves the promise.
 * @param {Function} reject A function that rejects the promise.
 * @param {object} response The response.
 */
module.exports = function settle(resolve, reject, response) {
  var validateStatus = response.config.validateStatus;
  if (!response.status || !validateStatus || validateStatus(response.status)) {
    resolve(response);
  } else {
    reject(createError(
      'Request failed with status code ' + response.status,
      response.config,
      null,
      response.request,
      response
    ));
  }
};


/***/ }),

/***/ "./node_modules/axios/lib/core/transformData.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/core/transformData.js ***!
  \******************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var defaults = __webpack_require__(/*! ./../defaults */ "./node_modules/axios/lib/defaults.js");

/**
 * Transform the data for a request or a response
 *
 * @param {Object|String} data The data to be transformed
 * @param {Array} headers The headers for the request or response
 * @param {Array|Function} fns A single function or Array of functions
 * @returns {*} The resulting transformed data
 */
module.exports = function transformData(data, headers, fns) {
  var context = this || defaults;
  /*eslint no-param-reassign:0*/
  utils.forEach(fns, function transform(fn) {
    data = fn.call(context, data, headers);
  });

  return data;
};


/***/ }),

/***/ "./node_modules/axios/lib/defaults.js":
/*!********************************************!*\
  !*** ./node_modules/axios/lib/defaults.js ***!
  \********************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";
/* provided dependency */ var process = __webpack_require__(/*! process/browser.js */ "./node_modules/process/browser.js");


var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
var normalizeHeaderName = __webpack_require__(/*! ./helpers/normalizeHeaderName */ "./node_modules/axios/lib/helpers/normalizeHeaderName.js");
var enhanceError = __webpack_require__(/*! ./core/enhanceError */ "./node_modules/axios/lib/core/enhanceError.js");

var DEFAULT_CONTENT_TYPE = {
  'Content-Type': 'application/x-www-form-urlencoded'
};

function setContentTypeIfUnset(headers, value) {
  if (!utils.isUndefined(headers) && utils.isUndefined(headers['Content-Type'])) {
    headers['Content-Type'] = value;
  }
}

function getDefaultAdapter() {
  var adapter;
  if (typeof XMLHttpRequest !== 'undefined') {
    // For browsers use XHR adapter
    adapter = __webpack_require__(/*! ./adapters/xhr */ "./node_modules/axios/lib/adapters/xhr.js");
  } else if (typeof process !== 'undefined' && Object.prototype.toString.call(process) === '[object process]') {
    // For node use HTTP adapter
    adapter = __webpack_require__(/*! ./adapters/http */ "./node_modules/axios/lib/adapters/xhr.js");
  }
  return adapter;
}

function stringifySafely(rawValue, parser, encoder) {
  if (utils.isString(rawValue)) {
    try {
      (parser || JSON.parse)(rawValue);
      return utils.trim(rawValue);
    } catch (e) {
      if (e.name !== 'SyntaxError') {
        throw e;
      }
    }
  }

  return (encoder || JSON.stringify)(rawValue);
}

var defaults = {

  transitional: {
    silentJSONParsing: true,
    forcedJSONParsing: true,
    clarifyTimeoutError: false
  },

  adapter: getDefaultAdapter(),

  transformRequest: [function transformRequest(data, headers) {
    normalizeHeaderName(headers, 'Accept');
    normalizeHeaderName(headers, 'Content-Type');

    if (utils.isFormData(data) ||
      utils.isArrayBuffer(data) ||
      utils.isBuffer(data) ||
      utils.isStream(data) ||
      utils.isFile(data) ||
      utils.isBlob(data)
    ) {
      return data;
    }
    if (utils.isArrayBufferView(data)) {
      return data.buffer;
    }
    if (utils.isURLSearchParams(data)) {
      setContentTypeIfUnset(headers, 'application/x-www-form-urlencoded;charset=utf-8');
      return data.toString();
    }
    if (utils.isObject(data) || (headers && headers['Content-Type'] === 'application/json')) {
      setContentTypeIfUnset(headers, 'application/json');
      return stringifySafely(data);
    }
    return data;
  }],

  transformResponse: [function transformResponse(data) {
    var transitional = this.transitional || defaults.transitional;
    var silentJSONParsing = transitional && transitional.silentJSONParsing;
    var forcedJSONParsing = transitional && transitional.forcedJSONParsing;
    var strictJSONParsing = !silentJSONParsing && this.responseType === 'json';

    if (strictJSONParsing || (forcedJSONParsing && utils.isString(data) && data.length)) {
      try {
        return JSON.parse(data);
      } catch (e) {
        if (strictJSONParsing) {
          if (e.name === 'SyntaxError') {
            throw enhanceError(e, this, 'E_JSON_PARSE');
          }
          throw e;
        }
      }
    }

    return data;
  }],

  /**
   * A timeout in milliseconds to abort a request. If set to 0 (default) a
   * timeout is not created.
   */
  timeout: 0,

  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN',

  maxContentLength: -1,
  maxBodyLength: -1,

  validateStatus: function validateStatus(status) {
    return status >= 200 && status < 300;
  },

  headers: {
    common: {
      'Accept': 'application/json, text/plain, */*'
    }
  }
};

utils.forEach(['delete', 'get', 'head'], function forEachMethodNoData(method) {
  defaults.headers[method] = {};
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  defaults.headers[method] = utils.merge(DEFAULT_CONTENT_TYPE);
});

module.exports = defaults;


/***/ }),

/***/ "./node_modules/axios/lib/env/data.js":
/*!********************************************!*\
  !*** ./node_modules/axios/lib/env/data.js ***!
  \********************************************/
/***/ ((module) => {

module.exports = {
  "version": "0.24.0"
};

/***/ }),

/***/ "./node_modules/axios/lib/helpers/bind.js":
/*!************************************************!*\
  !*** ./node_modules/axios/lib/helpers/bind.js ***!
  \************************************************/
/***/ ((module) => {

"use strict";


module.exports = function bind(fn, thisArg) {
  return function wrap() {
    var args = new Array(arguments.length);
    for (var i = 0; i < args.length; i++) {
      args[i] = arguments[i];
    }
    return fn.apply(thisArg, args);
  };
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/buildURL.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/helpers/buildURL.js ***!
  \****************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

function encode(val) {
  return encodeURIComponent(val).
    replace(/%3A/gi, ':').
    replace(/%24/g, '$').
    replace(/%2C/gi, ',').
    replace(/%20/g, '+').
    replace(/%5B/gi, '[').
    replace(/%5D/gi, ']');
}

/**
 * Build a URL by appending params to the end
 *
 * @param {string} url The base of the url (e.g., http://www.google.com)
 * @param {object} [params] The params to be appended
 * @returns {string} The formatted url
 */
module.exports = function buildURL(url, params, paramsSerializer) {
  /*eslint no-param-reassign:0*/
  if (!params) {
    return url;
  }

  var serializedParams;
  if (paramsSerializer) {
    serializedParams = paramsSerializer(params);
  } else if (utils.isURLSearchParams(params)) {
    serializedParams = params.toString();
  } else {
    var parts = [];

    utils.forEach(params, function serialize(val, key) {
      if (val === null || typeof val === 'undefined') {
        return;
      }

      if (utils.isArray(val)) {
        key = key + '[]';
      } else {
        val = [val];
      }

      utils.forEach(val, function parseValue(v) {
        if (utils.isDate(v)) {
          v = v.toISOString();
        } else if (utils.isObject(v)) {
          v = JSON.stringify(v);
        }
        parts.push(encode(key) + '=' + encode(v));
      });
    });

    serializedParams = parts.join('&');
  }

  if (serializedParams) {
    var hashmarkIndex = url.indexOf('#');
    if (hashmarkIndex !== -1) {
      url = url.slice(0, hashmarkIndex);
    }

    url += (url.indexOf('?') === -1 ? '?' : '&') + serializedParams;
  }

  return url;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/combineURLs.js":
/*!*******************************************************!*\
  !*** ./node_modules/axios/lib/helpers/combineURLs.js ***!
  \*******************************************************/
/***/ ((module) => {

"use strict";


/**
 * Creates a new URL by combining the specified URLs
 *
 * @param {string} baseURL The base URL
 * @param {string} relativeURL The relative URL
 * @returns {string} The combined URL
 */
module.exports = function combineURLs(baseURL, relativeURL) {
  return relativeURL
    ? baseURL.replace(/\/+$/, '') + '/' + relativeURL.replace(/^\/+/, '')
    : baseURL;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/cookies.js":
/*!***************************************************!*\
  !*** ./node_modules/axios/lib/helpers/cookies.js ***!
  \***************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs support document.cookie
    (function standardBrowserEnv() {
      return {
        write: function write(name, value, expires, path, domain, secure) {
          var cookie = [];
          cookie.push(name + '=' + encodeURIComponent(value));

          if (utils.isNumber(expires)) {
            cookie.push('expires=' + new Date(expires).toGMTString());
          }

          if (utils.isString(path)) {
            cookie.push('path=' + path);
          }

          if (utils.isString(domain)) {
            cookie.push('domain=' + domain);
          }

          if (secure === true) {
            cookie.push('secure');
          }

          document.cookie = cookie.join('; ');
        },

        read: function read(name) {
          var match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
          return (match ? decodeURIComponent(match[3]) : null);
        },

        remove: function remove(name) {
          this.write(name, '', Date.now() - 86400000);
        }
      };
    })() :

  // Non standard browser env (web workers, react-native) lack needed support.
    (function nonStandardBrowserEnv() {
      return {
        write: function write() {},
        read: function read() { return null; },
        remove: function remove() {}
      };
    })()
);


/***/ }),

/***/ "./node_modules/axios/lib/helpers/isAbsoluteURL.js":
/*!*********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isAbsoluteURL.js ***!
  \*********************************************************/
/***/ ((module) => {

"use strict";


/**
 * Determines whether the specified URL is absolute
 *
 * @param {string} url The URL to test
 * @returns {boolean} True if the specified URL is absolute, otherwise false
 */
module.exports = function isAbsoluteURL(url) {
  // A URL is considered absolute if it begins with "<scheme>://" or "//" (protocol-relative URL).
  // RFC 3986 defines scheme name as a sequence of characters beginning with a letter and followed
  // by any combination of letters, digits, plus, period, or hyphen.
  return /^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(url);
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/isAxiosError.js":
/*!********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isAxiosError.js ***!
  \********************************************************/
/***/ ((module) => {

"use strict";


/**
 * Determines whether the payload is an error thrown by Axios
 *
 * @param {*} payload The value to test
 * @returns {boolean} True if the payload is an error thrown by Axios, otherwise false
 */
module.exports = function isAxiosError(payload) {
  return (typeof payload === 'object') && (payload.isAxiosError === true);
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/isURLSameOrigin.js":
/*!***********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isURLSameOrigin.js ***!
  \***********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs have full support of the APIs needed to test
  // whether the request URL is of the same origin as current location.
    (function standardBrowserEnv() {
      var msie = /(msie|trident)/i.test(navigator.userAgent);
      var urlParsingNode = document.createElement('a');
      var originURL;

      /**
    * Parse a URL to discover it's components
    *
    * @param {String} url The URL to be parsed
    * @returns {Object}
    */
      function resolveURL(url) {
        var href = url;

        if (msie) {
        // IE needs attribute set twice to normalize properties
          urlParsingNode.setAttribute('href', href);
          href = urlParsingNode.href;
        }

        urlParsingNode.setAttribute('href', href);

        // urlParsingNode provides the UrlUtils interface - http://url.spec.whatwg.org/#urlutils
        return {
          href: urlParsingNode.href,
          protocol: urlParsingNode.protocol ? urlParsingNode.protocol.replace(/:$/, '') : '',
          host: urlParsingNode.host,
          search: urlParsingNode.search ? urlParsingNode.search.replace(/^\?/, '') : '',
          hash: urlParsingNode.hash ? urlParsingNode.hash.replace(/^#/, '') : '',
          hostname: urlParsingNode.hostname,
          port: urlParsingNode.port,
          pathname: (urlParsingNode.pathname.charAt(0) === '/') ?
            urlParsingNode.pathname :
            '/' + urlParsingNode.pathname
        };
      }

      originURL = resolveURL(window.location.href);

      /**
    * Determine if a URL shares the same origin as the current location
    *
    * @param {String} requestURL The URL to test
    * @returns {boolean} True if URL shares the same origin, otherwise false
    */
      return function isURLSameOrigin(requestURL) {
        var parsed = (utils.isString(requestURL)) ? resolveURL(requestURL) : requestURL;
        return (parsed.protocol === originURL.protocol &&
            parsed.host === originURL.host);
      };
    })() :

  // Non standard browser envs (web workers, react-native) lack needed support.
    (function nonStandardBrowserEnv() {
      return function isURLSameOrigin() {
        return true;
      };
    })()
);


/***/ }),

/***/ "./node_modules/axios/lib/helpers/normalizeHeaderName.js":
/*!***************************************************************!*\
  !*** ./node_modules/axios/lib/helpers/normalizeHeaderName.js ***!
  \***************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var utils = __webpack_require__(/*! ../utils */ "./node_modules/axios/lib/utils.js");

module.exports = function normalizeHeaderName(headers, normalizedName) {
  utils.forEach(headers, function processHeader(value, name) {
    if (name !== normalizedName && name.toUpperCase() === normalizedName.toUpperCase()) {
      headers[normalizedName] = value;
      delete headers[name];
    }
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/parseHeaders.js":
/*!********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/parseHeaders.js ***!
  \********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

// Headers whose duplicates are ignored by node
// c.f. https://nodejs.org/api/http.html#http_message_headers
var ignoreDuplicateOf = [
  'age', 'authorization', 'content-length', 'content-type', 'etag',
  'expires', 'from', 'host', 'if-modified-since', 'if-unmodified-since',
  'last-modified', 'location', 'max-forwards', 'proxy-authorization',
  'referer', 'retry-after', 'user-agent'
];

/**
 * Parse headers into an object
 *
 * ```
 * Date: Wed, 27 Aug 2014 08:58:49 GMT
 * Content-Type: application/json
 * Connection: keep-alive
 * Transfer-Encoding: chunked
 * ```
 *
 * @param {String} headers Headers needing to be parsed
 * @returns {Object} Headers parsed into an object
 */
module.exports = function parseHeaders(headers) {
  var parsed = {};
  var key;
  var val;
  var i;

  if (!headers) { return parsed; }

  utils.forEach(headers.split('\n'), function parser(line) {
    i = line.indexOf(':');
    key = utils.trim(line.substr(0, i)).toLowerCase();
    val = utils.trim(line.substr(i + 1));

    if (key) {
      if (parsed[key] && ignoreDuplicateOf.indexOf(key) >= 0) {
        return;
      }
      if (key === 'set-cookie') {
        parsed[key] = (parsed[key] ? parsed[key] : []).concat([val]);
      } else {
        parsed[key] = parsed[key] ? parsed[key] + ', ' + val : val;
      }
    }
  });

  return parsed;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/spread.js":
/*!**************************************************!*\
  !*** ./node_modules/axios/lib/helpers/spread.js ***!
  \**************************************************/
/***/ ((module) => {

"use strict";


/**
 * Syntactic sugar for invoking a function and expanding an array for arguments.
 *
 * Common use case would be to use `Function.prototype.apply`.
 *
 *  ```js
 *  function f(x, y, z) {}
 *  var args = [1, 2, 3];
 *  f.apply(null, args);
 *  ```
 *
 * With `spread` this example can be re-written.
 *
 *  ```js
 *  spread(function(x, y, z) {})([1, 2, 3]);
 *  ```
 *
 * @param {Function} callback
 * @returns {Function}
 */
module.exports = function spread(callback) {
  return function wrap(arr) {
    return callback.apply(null, arr);
  };
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/validator.js":
/*!*****************************************************!*\
  !*** ./node_modules/axios/lib/helpers/validator.js ***!
  \*****************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var VERSION = (__webpack_require__(/*! ../env/data */ "./node_modules/axios/lib/env/data.js").version);

var validators = {};

// eslint-disable-next-line func-names
['object', 'boolean', 'number', 'function', 'string', 'symbol'].forEach(function(type, i) {
  validators[type] = function validator(thing) {
    return typeof thing === type || 'a' + (i < 1 ? 'n ' : ' ') + type;
  };
});

var deprecatedWarnings = {};

/**
 * Transitional option validator
 * @param {function|boolean?} validator - set to false if the transitional option has been removed
 * @param {string?} version - deprecated version / removed since version
 * @param {string?} message - some message with additional info
 * @returns {function}
 */
validators.transitional = function transitional(validator, version, message) {
  function formatMessage(opt, desc) {
    return '[Axios v' + VERSION + '] Transitional option \'' + opt + '\'' + desc + (message ? '. ' + message : '');
  }

  // eslint-disable-next-line func-names
  return function(value, opt, opts) {
    if (validator === false) {
      throw new Error(formatMessage(opt, ' has been removed' + (version ? ' in ' + version : '')));
    }

    if (version && !deprecatedWarnings[opt]) {
      deprecatedWarnings[opt] = true;
      // eslint-disable-next-line no-console
      console.warn(
        formatMessage(
          opt,
          ' has been deprecated since v' + version + ' and will be removed in the near future'
        )
      );
    }

    return validator ? validator(value, opt, opts) : true;
  };
};

/**
 * Assert object's properties type
 * @param {object} options
 * @param {object} schema
 * @param {boolean?} allowUnknown
 */

function assertOptions(options, schema, allowUnknown) {
  if (typeof options !== 'object') {
    throw new TypeError('options must be an object');
  }
  var keys = Object.keys(options);
  var i = keys.length;
  while (i-- > 0) {
    var opt = keys[i];
    var validator = schema[opt];
    if (validator) {
      var value = options[opt];
      var result = value === undefined || validator(value, opt, options);
      if (result !== true) {
        throw new TypeError('option ' + opt + ' must be ' + result);
      }
      continue;
    }
    if (allowUnknown !== true) {
      throw Error('Unknown option ' + opt);
    }
  }
}

module.exports = {
  assertOptions: assertOptions,
  validators: validators
};


/***/ }),

/***/ "./node_modules/axios/lib/utils.js":
/*!*****************************************!*\
  !*** ./node_modules/axios/lib/utils.js ***!
  \*****************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");

// utils is a library of generic helper functions non-specific to axios

var toString = Object.prototype.toString;

/**
 * Determine if a value is an Array
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Array, otherwise false
 */
function isArray(val) {
  return toString.call(val) === '[object Array]';
}

/**
 * Determine if a value is undefined
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if the value is undefined, otherwise false
 */
function isUndefined(val) {
  return typeof val === 'undefined';
}

/**
 * Determine if a value is a Buffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Buffer, otherwise false
 */
function isBuffer(val) {
  return val !== null && !isUndefined(val) && val.constructor !== null && !isUndefined(val.constructor)
    && typeof val.constructor.isBuffer === 'function' && val.constructor.isBuffer(val);
}

/**
 * Determine if a value is an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an ArrayBuffer, otherwise false
 */
function isArrayBuffer(val) {
  return toString.call(val) === '[object ArrayBuffer]';
}

/**
 * Determine if a value is a FormData
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an FormData, otherwise false
 */
function isFormData(val) {
  return (typeof FormData !== 'undefined') && (val instanceof FormData);
}

/**
 * Determine if a value is a view on an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a view on an ArrayBuffer, otherwise false
 */
function isArrayBufferView(val) {
  var result;
  if ((typeof ArrayBuffer !== 'undefined') && (ArrayBuffer.isView)) {
    result = ArrayBuffer.isView(val);
  } else {
    result = (val) && (val.buffer) && (val.buffer instanceof ArrayBuffer);
  }
  return result;
}

/**
 * Determine if a value is a String
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a String, otherwise false
 */
function isString(val) {
  return typeof val === 'string';
}

/**
 * Determine if a value is a Number
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Number, otherwise false
 */
function isNumber(val) {
  return typeof val === 'number';
}

/**
 * Determine if a value is an Object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Object, otherwise false
 */
function isObject(val) {
  return val !== null && typeof val === 'object';
}

/**
 * Determine if a value is a plain Object
 *
 * @param {Object} val The value to test
 * @return {boolean} True if value is a plain Object, otherwise false
 */
function isPlainObject(val) {
  if (toString.call(val) !== '[object Object]') {
    return false;
  }

  var prototype = Object.getPrototypeOf(val);
  return prototype === null || prototype === Object.prototype;
}

/**
 * Determine if a value is a Date
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Date, otherwise false
 */
function isDate(val) {
  return toString.call(val) === '[object Date]';
}

/**
 * Determine if a value is a File
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a File, otherwise false
 */
function isFile(val) {
  return toString.call(val) === '[object File]';
}

/**
 * Determine if a value is a Blob
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Blob, otherwise false
 */
function isBlob(val) {
  return toString.call(val) === '[object Blob]';
}

/**
 * Determine if a value is a Function
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Function, otherwise false
 */
function isFunction(val) {
  return toString.call(val) === '[object Function]';
}

/**
 * Determine if a value is a Stream
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Stream, otherwise false
 */
function isStream(val) {
  return isObject(val) && isFunction(val.pipe);
}

/**
 * Determine if a value is a URLSearchParams object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a URLSearchParams object, otherwise false
 */
function isURLSearchParams(val) {
  return typeof URLSearchParams !== 'undefined' && val instanceof URLSearchParams;
}

/**
 * Trim excess whitespace off the beginning and end of a string
 *
 * @param {String} str The String to trim
 * @returns {String} The String freed of excess whitespace
 */
function trim(str) {
  return str.trim ? str.trim() : str.replace(/^\s+|\s+$/g, '');
}

/**
 * Determine if we're running in a standard browser environment
 *
 * This allows axios to run in a web worker, and react-native.
 * Both environments support XMLHttpRequest, but not fully standard globals.
 *
 * web workers:
 *  typeof window -> undefined
 *  typeof document -> undefined
 *
 * react-native:
 *  navigator.product -> 'ReactNative'
 * nativescript
 *  navigator.product -> 'NativeScript' or 'NS'
 */
function isStandardBrowserEnv() {
  if (typeof navigator !== 'undefined' && (navigator.product === 'ReactNative' ||
                                           navigator.product === 'NativeScript' ||
                                           navigator.product === 'NS')) {
    return false;
  }
  return (
    typeof window !== 'undefined' &&
    typeof document !== 'undefined'
  );
}

/**
 * Iterate over an Array or an Object invoking a function for each item.
 *
 * If `obj` is an Array callback will be called passing
 * the value, index, and complete array for each item.
 *
 * If 'obj' is an Object callback will be called passing
 * the value, key, and complete object for each property.
 *
 * @param {Object|Array} obj The object to iterate
 * @param {Function} fn The callback to invoke for each item
 */
function forEach(obj, fn) {
  // Don't bother if no value provided
  if (obj === null || typeof obj === 'undefined') {
    return;
  }

  // Force an array if not already something iterable
  if (typeof obj !== 'object') {
    /*eslint no-param-reassign:0*/
    obj = [obj];
  }

  if (isArray(obj)) {
    // Iterate over array values
    for (var i = 0, l = obj.length; i < l; i++) {
      fn.call(null, obj[i], i, obj);
    }
  } else {
    // Iterate over object keys
    for (var key in obj) {
      if (Object.prototype.hasOwnProperty.call(obj, key)) {
        fn.call(null, obj[key], key, obj);
      }
    }
  }
}

/**
 * Accepts varargs expecting each argument to be an object, then
 * immutably merges the properties of each object and returns result.
 *
 * When multiple objects contain the same key the later object in
 * the arguments list will take precedence.
 *
 * Example:
 *
 * ```js
 * var result = merge({foo: 123}, {foo: 456});
 * console.log(result.foo); // outputs 456
 * ```
 *
 * @param {Object} obj1 Object to merge
 * @returns {Object} Result of all merge properties
 */
function merge(/* obj1, obj2, obj3, ... */) {
  var result = {};
  function assignValue(val, key) {
    if (isPlainObject(result[key]) && isPlainObject(val)) {
      result[key] = merge(result[key], val);
    } else if (isPlainObject(val)) {
      result[key] = merge({}, val);
    } else if (isArray(val)) {
      result[key] = val.slice();
    } else {
      result[key] = val;
    }
  }

  for (var i = 0, l = arguments.length; i < l; i++) {
    forEach(arguments[i], assignValue);
  }
  return result;
}

/**
 * Extends object a by mutably adding to it the properties of object b.
 *
 * @param {Object} a The object to be extended
 * @param {Object} b The object to copy properties from
 * @param {Object} thisArg The object to bind function to
 * @return {Object} The resulting value of object a
 */
function extend(a, b, thisArg) {
  forEach(b, function assignValue(val, key) {
    if (thisArg && typeof val === 'function') {
      a[key] = bind(val, thisArg);
    } else {
      a[key] = val;
    }
  });
  return a;
}

/**
 * Remove byte order marker. This catches EF BB BF (the UTF-8 BOM)
 *
 * @param {string} content with BOM
 * @return {string} content value without BOM
 */
function stripBOM(content) {
  if (content.charCodeAt(0) === 0xFEFF) {
    content = content.slice(1);
  }
  return content;
}

module.exports = {
  isArray: isArray,
  isArrayBuffer: isArrayBuffer,
  isBuffer: isBuffer,
  isFormData: isFormData,
  isArrayBufferView: isArrayBufferView,
  isString: isString,
  isNumber: isNumber,
  isObject: isObject,
  isPlainObject: isPlainObject,
  isUndefined: isUndefined,
  isDate: isDate,
  isFile: isFile,
  isBlob: isBlob,
  isFunction: isFunction,
  isStream: isStream,
  isURLSearchParams: isURLSearchParams,
  isStandardBrowserEnv: isStandardBrowserEnv,
  forEach: forEach,
  merge: merge,
  extend: extend,
  trim: trim,
  stripBOM: stripBOM
};


/***/ }),

/***/ "./node_modules/muuri/dist/muuri.module.js":
/*!*************************************************!*\
  !*** ./node_modules/muuri/dist/muuri.module.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
* Muuri v0.9.5
* https://muuri.dev/
* Copyright (c) 2015-present, Haltu Oy
* Released under the MIT license
* https://github.com/haltu/muuri/blob/master/LICENSE.md
* @license MIT
*
* Muuri Packer
* Copyright (c) 2016-present, Niklas Rämö <inramo@gmail.com>
* @license MIT
*
* Muuri Ticker / Muuri Emitter / Muuri Dragger
* Copyright (c) 2018-present, Niklas Rämö <inramo@gmail.com>
* @license MIT
*
* Muuri AutoScroller
* Copyright (c) 2019-present, Niklas Rämö <inramo@gmail.com>
* @license MIT
*/

var GRID_INSTANCES = {};
var ITEM_ELEMENT_MAP = typeof Map === 'function' ? new Map() : null;

var ACTION_SWAP = 'swap';
var ACTION_MOVE = 'move';

var EVENT_SYNCHRONIZE = 'synchronize';
var EVENT_LAYOUT_START = 'layoutStart';
var EVENT_LAYOUT_END = 'layoutEnd';
var EVENT_LAYOUT_ABORT = 'layoutAbort';
var EVENT_ADD = 'add';
var EVENT_REMOVE = 'remove';
var EVENT_SHOW_START = 'showStart';
var EVENT_SHOW_END = 'showEnd';
var EVENT_HIDE_START = 'hideStart';
var EVENT_HIDE_END = 'hideEnd';
var EVENT_FILTER = 'filter';
var EVENT_SORT = 'sort';
var EVENT_MOVE = 'move';
var EVENT_SEND = 'send';
var EVENT_BEFORE_SEND = 'beforeSend';
var EVENT_RECEIVE = 'receive';
var EVENT_BEFORE_RECEIVE = 'beforeReceive';
var EVENT_DRAG_INIT = 'dragInit';
var EVENT_DRAG_START = 'dragStart';
var EVENT_DRAG_MOVE = 'dragMove';
var EVENT_DRAG_SCROLL = 'dragScroll';
var EVENT_DRAG_END = 'dragEnd';
var EVENT_DRAG_RELEASE_START = 'dragReleaseStart';
var EVENT_DRAG_RELEASE_END = 'dragReleaseEnd';
var EVENT_DESTROY = 'destroy';

var HAS_TOUCH_EVENTS = 'ontouchstart' in window;
var HAS_POINTER_EVENTS = !!window.PointerEvent;
var HAS_MS_POINTER_EVENTS = !!window.navigator.msPointerEnabled;

var MAX_SAFE_FLOAT32_INTEGER = 16777216;

/**
 * Event emitter constructor.
 *
 * @class
 */
function Emitter() {
  this._events = {};
  this._queue = [];
  this._counter = 0;
  this._clearOnEmit = false;
}

/**
 * Public prototype methods
 * ************************
 */

/**
 * Bind an event listener.
 *
 * @public
 * @param {String} event
 * @param {Function} listener
 * @returns {Emitter}
 */
Emitter.prototype.on = function (event, listener) {
  if (!this._events || !event || !listener) return this;

  // Get listeners queue and create it if it does not exist.
  var listeners = this._events[event];
  if (!listeners) listeners = this._events[event] = [];

  // Add the listener to the queue.
  listeners.push(listener);

  return this;
};

/**
 * Unbind all event listeners that match the provided listener function.
 *
 * @public
 * @param {String} event
 * @param {Function} listener
 * @returns {Emitter}
 */
Emitter.prototype.off = function (event, listener) {
  if (!this._events || !event || !listener) return this;

  // Get listeners and return immediately if none is found.
  var listeners = this._events[event];
  if (!listeners || !listeners.length) return this;

  // Remove all matching listeners.
  var index;
  while ((index = listeners.indexOf(listener)) !== -1) {
    listeners.splice(index, 1);
  }

  return this;
};

/**
 * Unbind all listeners of the provided event.
 *
 * @public
 * @param {String} event
 * @returns {Emitter}
 */
Emitter.prototype.clear = function (event) {
  if (!this._events || !event) return this;

  var listeners = this._events[event];
  if (listeners) {
    listeners.length = 0;
    delete this._events[event];
  }

  return this;
};

/**
 * Emit all listeners in a specified event with the provided arguments.
 *
 * @public
 * @param {String} event
 * @param {...*} [args]
 * @returns {Emitter}
 */
Emitter.prototype.emit = function (event) {
  if (!this._events || !event) {
    this._clearOnEmit = false;
    return this;
  }

  // Get event listeners and quit early if there's no listeners.
  var listeners = this._events[event];
  if (!listeners || !listeners.length) {
    this._clearOnEmit = false;
    return this;
  }

  var queue = this._queue;
  var startIndex = queue.length;
  var argsLength = arguments.length - 1;
  var args;

  // If we have more than 3 arguments let's put the arguments in an array and
  // apply it to the listeners.
  if (argsLength > 3) {
    args = [];
    args.push.apply(args, arguments);
    args.shift();
  }

  // Add the current listeners to the callback queue before we process them.
  // This is necessary to guarantee that all of the listeners are called in
  // correct order even if new event listeners are removed/added during
  // processing and/or events are emitted during processing.
  queue.push.apply(queue, listeners);

  // Reset the event's listeners if need be.
  if (this._clearOnEmit) {
    listeners.length = 0;
    this._clearOnEmit = false;
  }

  // Increment queue counter. This is needed for the scenarios where emit is
  // triggered while the queue is already processing. We need to keep track of
  // how many "queue processors" there are active so that we can safely reset
  // the queue in the end when the last queue processor is finished.
  ++this._counter;

  // Process the queue (the specific part of it for this emit).
  var i = startIndex;
  var endIndex = queue.length;
  for (; i < endIndex; i++) {
    // prettier-ignore
    argsLength === 0 ? queue[i]() :
    argsLength === 1 ? queue[i](arguments[1]) :
    argsLength === 2 ? queue[i](arguments[1], arguments[2]) :
    argsLength === 3 ? queue[i](arguments[1], arguments[2], arguments[3]) :
                       queue[i].apply(null, args);

    // Stop processing if the emitter is destroyed.
    if (!this._events) return this;
  }

  // Decrement queue process counter.
  --this._counter;

  // Reset the queue if there are no more queue processes running.
  if (!this._counter) queue.length = 0;

  return this;
};

/**
 * Emit all listeners in a specified event with the provided arguments and
 * remove the event's listeners just before calling the them. This method allows
 * the emitter to serve as a queue where all listeners are called only once.
 *
 * @public
 * @param {String} event
 * @param {...*} [args]
 * @returns {Emitter}
 */
Emitter.prototype.burst = function () {
  if (!this._events) return this;
  this._clearOnEmit = true;
  this.emit.apply(this, arguments);
  return this;
};

/**
 * Check how many listeners there are for a specific event.
 *
 * @public
 * @param {String} event
 * @returns {Boolean}
 */
Emitter.prototype.countListeners = function (event) {
  if (!this._events) return 0;
  var listeners = this._events[event];
  return listeners ? listeners.length : 0;
};

/**
 * Destroy emitter instance. Basically just removes all bound listeners.
 *
 * @public
 * @returns {Emitter}
 */
Emitter.prototype.destroy = function () {
  if (!this._events) return this;
  this._queue.length = this._counter = 0;
  this._events = null;
  return this;
};

var pointerout = HAS_POINTER_EVENTS ? 'pointerout' : HAS_MS_POINTER_EVENTS ? 'MSPointerOut' : '';
var waitDuration = 100;

/**
 * If you happen to use Edge or IE on a touch capable device there is a
 * a specific case where pointercancel and pointerend events are never emitted,
 * even though one them should always be emitted when you release your finger
 * from the screen. The bug appears specifically when Muuri shifts the dragged
 * element's position in the DOM after pointerdown event, IE and Edge don't like
 * that behaviour and quite often forget to emit the pointerend/pointercancel
 * event. But, they do emit pointerout event so we utilize that here.
 * Specifically, if there has been no pointermove event within 100 milliseconds
 * since the last pointerout event we force cancel the drag operation. This hack
 * works surprisingly well 99% of the time. There is that 1% chance there still
 * that dragged items get stuck but it is what it is.
 *
 * @class
 * @param {Dragger} dragger
 */
function EdgeHack(dragger) {
  if (!pointerout) return;

  this._dragger = dragger;
  this._timeout = null;
  this._outEvent = null;
  this._isActive = false;

  this._addBehaviour = this._addBehaviour.bind(this);
  this._removeBehaviour = this._removeBehaviour.bind(this);
  this._onTimeout = this._onTimeout.bind(this);
  this._resetData = this._resetData.bind(this);
  this._onStart = this._onStart.bind(this);
  this._onOut = this._onOut.bind(this);

  this._dragger.on('start', this._onStart);
}

/**
 * @private
 */
EdgeHack.prototype._addBehaviour = function () {
  if (this._isActive) return;
  this._isActive = true;
  this._dragger.on('move', this._resetData);
  this._dragger.on('cancel', this._removeBehaviour);
  this._dragger.on('end', this._removeBehaviour);
  window.addEventListener(pointerout, this._onOut);
};

/**
 * @private
 */
EdgeHack.prototype._removeBehaviour = function () {
  if (!this._isActive) return;
  this._dragger.off('move', this._resetData);
  this._dragger.off('cancel', this._removeBehaviour);
  this._dragger.off('end', this._removeBehaviour);
  window.removeEventListener(pointerout, this._onOut);
  this._resetData();
  this._isActive = false;
};

/**
 * @private
 */
EdgeHack.prototype._resetData = function () {
  window.clearTimeout(this._timeout);
  this._timeout = null;
  this._outEvent = null;
};

/**
 * @private
 * @param {(PointerEvent|TouchEvent|MouseEvent)} e
 */
EdgeHack.prototype._onStart = function (e) {
  if (e.pointerType === 'mouse') return;
  this._addBehaviour();
};

/**
 * @private
 * @param {(PointerEvent|TouchEvent|MouseEvent)} e
 */
EdgeHack.prototype._onOut = function (e) {
  if (!this._dragger._getTrackedTouch(e)) return;
  this._resetData();
  this._outEvent = e;
  this._timeout = window.setTimeout(this._onTimeout, waitDuration);
};

/**
 * @private
 */
EdgeHack.prototype._onTimeout = function () {
  var e = this._outEvent;
  this._resetData();
  if (this._dragger.isActive()) this._dragger._onCancel(e);
};

/**
 * @public
 */
EdgeHack.prototype.destroy = function () {
  if (!pointerout) return;
  this._dragger.off('start', this._onStart);
  this._removeBehaviour();
};

// Playing it safe here, test all potential prefixes capitalized and lowercase.
var vendorPrefixes = ['', 'webkit', 'moz', 'ms', 'o', 'Webkit', 'Moz', 'MS', 'O'];
var cache$2 = {};

/**
 * Get prefixed CSS property name when given a non-prefixed CSS property name.
 * Returns null if the property is not supported at all.
 *
 * @param {CSSStyleDeclaration} style
 * @param {String} prop
 * @returns {String}
 */
function getPrefixedPropName(style, prop) {
  var prefixedProp = cache$2[prop] || '';
  if (prefixedProp) return prefixedProp;

  var camelProp = prop[0].toUpperCase() + prop.slice(1);
  var i = 0;
  while (i < vendorPrefixes.length) {
    prefixedProp = vendorPrefixes[i] ? vendorPrefixes[i] + camelProp : prop;
    if (prefixedProp in style) {
      cache$2[prop] = prefixedProp;
      return prefixedProp;
    }
    ++i;
  }

  return '';
}

/**
 * Check if passive events are supported.
 * https://github.com/WICG/EventListenerOptions/blob/gh-pages/explainer.md#feature-detection
 *
 * @returns {Boolean}
 */
function hasPassiveEvents() {
  var isPassiveEventsSupported = false;

  try {
    var passiveOpts = Object.defineProperty({}, 'passive', {
      get: function () {
        isPassiveEventsSupported = true;
      },
    });
    window.addEventListener('testPassive', null, passiveOpts);
    window.removeEventListener('testPassive', null, passiveOpts);
  } catch (e) {}

  return isPassiveEventsSupported;
}

var ua = window.navigator.userAgent.toLowerCase();
var isEdge = ua.indexOf('edge') > -1;
var isIE = ua.indexOf('trident') > -1;
var isFirefox = ua.indexOf('firefox') > -1;
var isAndroid = ua.indexOf('android') > -1;

var listenerOptions = hasPassiveEvents() ? { passive: true } : false;

var taProp = 'touchAction';
var taPropPrefixed = getPrefixedPropName(document.documentElement.style, taProp);
var taDefaultValue = 'auto';

/**
 * Creates a new Dragger instance for an element.
 *
 * @public
 * @class
 * @param {HTMLElement} element
 * @param {Object} [cssProps]
 */
function Dragger(element, cssProps) {
  this._element = element;
  this._emitter = new Emitter();
  this._isDestroyed = false;
  this._cssProps = {};
  this._touchAction = '';
  this._isActive = false;

  this._pointerId = null;
  this._startTime = 0;
  this._startX = 0;
  this._startY = 0;
  this._currentX = 0;
  this._currentY = 0;

  this._onStart = this._onStart.bind(this);
  this._onMove = this._onMove.bind(this);
  this._onCancel = this._onCancel.bind(this);
  this._onEnd = this._onEnd.bind(this);

  // Can't believe had to build a freaking class for a hack!
  this._edgeHack = null;
  if ((isEdge || isIE) && (HAS_POINTER_EVENTS || HAS_MS_POINTER_EVENTS)) {
    this._edgeHack = new EdgeHack(this);
  }

  // Apply initial CSS props.
  this.setCssProps(cssProps);

  // If touch action was not provided with initial CSS props let's assume it's
  // auto.
  if (!this._touchAction) {
    this.setTouchAction(taDefaultValue);
  }

  // Prevent native link/image dragging for the item and it's children.
  element.addEventListener('dragstart', Dragger._preventDefault, false);

  // Listen to start event.
  element.addEventListener(Dragger._inputEvents.start, this._onStart, listenerOptions);
}

/**
 * Protected properties
 * ********************
 */

Dragger._pointerEvents = {
  start: 'pointerdown',
  move: 'pointermove',
  cancel: 'pointercancel',
  end: 'pointerup',
};

Dragger._msPointerEvents = {
  start: 'MSPointerDown',
  move: 'MSPointerMove',
  cancel: 'MSPointerCancel',
  end: 'MSPointerUp',
};

Dragger._touchEvents = {
  start: 'touchstart',
  move: 'touchmove',
  cancel: 'touchcancel',
  end: 'touchend',
};

Dragger._mouseEvents = {
  start: 'mousedown',
  move: 'mousemove',
  cancel: '',
  end: 'mouseup',
};

Dragger._inputEvents = (function () {
  if (HAS_TOUCH_EVENTS) return Dragger._touchEvents;
  if (HAS_POINTER_EVENTS) return Dragger._pointerEvents;
  if (HAS_MS_POINTER_EVENTS) return Dragger._msPointerEvents;
  return Dragger._mouseEvents;
})();

Dragger._emitter = new Emitter();

Dragger._emitterEvents = {
  start: 'start',
  move: 'move',
  end: 'end',
  cancel: 'cancel',
};

Dragger._activeInstances = [];

/**
 * Protected static methods
 * ************************
 */

Dragger._preventDefault = function (e) {
  if (e.preventDefault && e.cancelable !== false) e.preventDefault();
};

Dragger._activateInstance = function (instance) {
  var index = Dragger._activeInstances.indexOf(instance);
  if (index > -1) return;

  Dragger._activeInstances.push(instance);
  Dragger._emitter.on(Dragger._emitterEvents.move, instance._onMove);
  Dragger._emitter.on(Dragger._emitterEvents.cancel, instance._onCancel);
  Dragger._emitter.on(Dragger._emitterEvents.end, instance._onEnd);

  if (Dragger._activeInstances.length === 1) {
    Dragger._bindListeners();
  }
};

Dragger._deactivateInstance = function (instance) {
  var index = Dragger._activeInstances.indexOf(instance);
  if (index === -1) return;

  Dragger._activeInstances.splice(index, 1);
  Dragger._emitter.off(Dragger._emitterEvents.move, instance._onMove);
  Dragger._emitter.off(Dragger._emitterEvents.cancel, instance._onCancel);
  Dragger._emitter.off(Dragger._emitterEvents.end, instance._onEnd);

  if (!Dragger._activeInstances.length) {
    Dragger._unbindListeners();
  }
};

Dragger._bindListeners = function () {
  window.addEventListener(Dragger._inputEvents.move, Dragger._onMove, listenerOptions);
  window.addEventListener(Dragger._inputEvents.end, Dragger._onEnd, listenerOptions);
  if (Dragger._inputEvents.cancel) {
    window.addEventListener(Dragger._inputEvents.cancel, Dragger._onCancel, listenerOptions);
  }
};

Dragger._unbindListeners = function () {
  window.removeEventListener(Dragger._inputEvents.move, Dragger._onMove, listenerOptions);
  window.removeEventListener(Dragger._inputEvents.end, Dragger._onEnd, listenerOptions);
  if (Dragger._inputEvents.cancel) {
    window.removeEventListener(Dragger._inputEvents.cancel, Dragger._onCancel, listenerOptions);
  }
};

Dragger._getEventPointerId = function (event) {
  // If we have pointer id available let's use it.
  if (typeof event.pointerId === 'number') {
    return event.pointerId;
  }

  // For touch events let's get the first changed touch's identifier.
  if (event.changedTouches) {
    return event.changedTouches[0] ? event.changedTouches[0].identifier : null;
  }

  // For mouse/other events let's provide a static id.
  return 1;
};

Dragger._getTouchById = function (event, id) {
  // If we have a pointer event return the whole event if there's a match, and
  // null otherwise.
  if (typeof event.pointerId === 'number') {
    return event.pointerId === id ? event : null;
  }

  // For touch events let's check if there's a changed touch object that matches
  // the pointerId in which case return the touch object.
  if (event.changedTouches) {
    for (var i = 0; i < event.changedTouches.length; i++) {
      if (event.changedTouches[i].identifier === id) {
        return event.changedTouches[i];
      }
    }
    return null;
  }

  // For mouse/other events let's assume there's only one pointer and just
  // return the event.
  return event;
};

Dragger._onMove = function (e) {
  Dragger._emitter.emit(Dragger._emitterEvents.move, e);
};

Dragger._onCancel = function (e) {
  Dragger._emitter.emit(Dragger._emitterEvents.cancel, e);
};

Dragger._onEnd = function (e) {
  Dragger._emitter.emit(Dragger._emitterEvents.end, e);
};

/**
 * Private prototype methods
 * *************************
 */

/**
 * Reset current drag operation (if any).
 *
 * @private
 */
Dragger.prototype._reset = function () {
  this._pointerId = null;
  this._startTime = 0;
  this._startX = 0;
  this._startY = 0;
  this._currentX = 0;
  this._currentY = 0;
  this._isActive = false;
  Dragger._deactivateInstance(this);
};

/**
 * Create a custom dragger event from a raw event.
 *
 * @private
 * @param {String} type
 * @param {(PointerEvent|TouchEvent|MouseEvent)} e
 * @returns {Object}
 */
Dragger.prototype._createEvent = function (type, e) {
  var touch = this._getTrackedTouch(e);
  return {
    // Hammer.js compatibility interface.
    type: type,
    srcEvent: e,
    distance: this.getDistance(),
    deltaX: this.getDeltaX(),
    deltaY: this.getDeltaY(),
    deltaTime: type === Dragger._emitterEvents.start ? 0 : this.getDeltaTime(),
    isFirst: type === Dragger._emitterEvents.start,
    isFinal: type === Dragger._emitterEvents.end || type === Dragger._emitterEvents.cancel,
    pointerType: e.pointerType || (e.touches ? 'touch' : 'mouse'),
    // Partial Touch API interface.
    identifier: this._pointerId,
    screenX: touch.screenX,
    screenY: touch.screenY,
    clientX: touch.clientX,
    clientY: touch.clientY,
    pageX: touch.pageX,
    pageY: touch.pageY,
    target: touch.target,
  };
};

/**
 * Emit a raw event as dragger event internally.
 *
 * @private
 * @param {String} type
 * @param {(PointerEvent|TouchEvent|MouseEvent)} e
 */
Dragger.prototype._emit = function (type, e) {
  this._emitter.emit(type, this._createEvent(type, e));
};

/**
 * If the provided event is a PointerEvent this method will return it if it has
 * the same pointerId as the instance. If the provided event is a TouchEvent
 * this method will try to look for a Touch instance in the changedTouches that
 * has an identifier matching this instance's pointerId. If the provided event
 * is a MouseEvent (or just any other event than PointerEvent or TouchEvent)
 * it will be returned immediately.
 *
 * @private
 * @param {(PointerEvent|TouchEvent|MouseEvent)} e
 * @returns {?(Touch|PointerEvent|MouseEvent)}
 */
Dragger.prototype._getTrackedTouch = function (e) {
  if (this._pointerId === null) return null;
  return Dragger._getTouchById(e, this._pointerId);
};

/**
 * Handler for start event.
 *
 * @private
 * @param {(PointerEvent|TouchEvent|MouseEvent)} e
 */
Dragger.prototype._onStart = function (e) {
  if (this._isDestroyed) return;

  // If pointer id is already assigned let's return early.
  if (this._pointerId !== null) return;

  // Get (and set) pointer id.
  this._pointerId = Dragger._getEventPointerId(e);
  if (this._pointerId === null) return;

  // Setup initial data and emit start event.
  var touch = this._getTrackedTouch(e);
  this._startX = this._currentX = touch.clientX;
  this._startY = this._currentY = touch.clientY;
  this._startTime = Date.now();
  this._isActive = true;
  this._emit(Dragger._emitterEvents.start, e);

  // If the drag procedure was not reset within the start procedure let's
  // activate the instance (start listening to move/cancel/end events).
  if (this._isActive) {
    Dragger._activateInstance(this);
  }
};

/**
 * Handler for move event.
 *
 * @private
 * @param {(PointerEvent|TouchEvent|MouseEvent)} e
 */
Dragger.prototype._onMove = function (e) {
  var touch = this._getTrackedTouch(e);
  if (!touch) return;
  this._currentX = touch.clientX;
  this._currentY = touch.clientY;
  this._emit(Dragger._emitterEvents.move, e);
};

/**
 * Handler for cancel event.
 *
 * @private
 * @param {(PointerEvent|TouchEvent|MouseEvent)} e
 */
Dragger.prototype._onCancel = function (e) {
  if (!this._getTrackedTouch(e)) return;
  this._emit(Dragger._emitterEvents.cancel, e);
  this._reset();
};

/**
 * Handler for end event.
 *
 * @private
 * @param {(PointerEvent|TouchEvent|MouseEvent)} e
 */
Dragger.prototype._onEnd = function (e) {
  if (!this._getTrackedTouch(e)) return;
  this._emit(Dragger._emitterEvents.end, e);
  this._reset();
};

/**
 * Public prototype methods
 * ************************
 */

/**
 * Check if the element is being dragged at the moment.
 *
 * @public
 * @returns {Boolean}
 */
Dragger.prototype.isActive = function () {
  return this._isActive;
};

/**
 * Set element's touch-action CSS property.
 *
 * @public
 * @param {String} value
 */
Dragger.prototype.setTouchAction = function (value) {
  // Store unmodified touch action value (we trust user input here).
  this._touchAction = value;

  // Set touch-action style.
  if (taPropPrefixed) {
    this._cssProps[taPropPrefixed] = '';
    this._element.style[taPropPrefixed] = value;
  }

  // If we have an unsupported touch-action value let's add a special listener
  // that prevents default action on touch start event. A dirty hack, but best
  // we can do for now. The other options would be to somehow polyfill the
  // unsupported touch action behavior with custom heuristics which sounds like
  // a can of worms. We do a special exception here for Firefox Android which's
  // touch-action does not work properly if the dragged element is moved in the
  // the DOM tree on touchstart.
  if (HAS_TOUCH_EVENTS) {
    this._element.removeEventListener(Dragger._touchEvents.start, Dragger._preventDefault, true);
    if (this._element.style[taPropPrefixed] !== value || (isFirefox && isAndroid)) {
      this._element.addEventListener(Dragger._touchEvents.start, Dragger._preventDefault, true);
    }
  }
};

/**
 * Update element's CSS properties. Accepts an object with camel cased style
 * props with value pairs as it's first argument.
 *
 * @public
 * @param {Object} [newProps]
 */
Dragger.prototype.setCssProps = function (newProps) {
  if (!newProps) return;

  var currentProps = this._cssProps;
  var element = this._element;
  var prop;
  var prefixedProp;

  // Reset current props.
  for (prop in currentProps) {
    element.style[prop] = currentProps[prop];
    delete currentProps[prop];
  }

  // Set new props.
  for (prop in newProps) {
    // Make sure we have a value for the prop.
    if (!newProps[prop]) continue;

    // Special handling for touch-action.
    if (prop === taProp) {
      this.setTouchAction(newProps[prop]);
      continue;
    }

    // Get prefixed prop and skip if it does not exist.
    prefixedProp = getPrefixedPropName(element.style, prop);
    if (!prefixedProp) continue;

    // Store the prop and add the style.
    currentProps[prefixedProp] = '';
    element.style[prefixedProp] = newProps[prop];
  }
};

/**
 * How much the pointer has moved on x-axis from start position, in pixels.
 * Positive value indicates movement from left to right.
 *
 * @public
 * @returns {Number}
 */
Dragger.prototype.getDeltaX = function () {
  return this._currentX - this._startX;
};

/**
 * How much the pointer has moved on y-axis from start position, in pixels.
 * Positive value indicates movement from top to bottom.
 *
 * @public
 * @returns {Number}
 */
Dragger.prototype.getDeltaY = function () {
  return this._currentY - this._startY;
};

/**
 * How far (in pixels) has pointer moved from start position.
 *
 * @public
 * @returns {Number}
 */
Dragger.prototype.getDistance = function () {
  var x = this.getDeltaX();
  var y = this.getDeltaY();
  return Math.sqrt(x * x + y * y);
};

/**
 * How long has pointer been dragged.
 *
 * @public
 * @returns {Number}
 */
Dragger.prototype.getDeltaTime = function () {
  return this._startTime ? Date.now() - this._startTime : 0;
};

/**
 * Bind drag event listeners.
 *
 * @public
 * @param {String} eventName
 *   - 'start', 'move', 'cancel' or 'end'.
 * @param {Function} listener
 */
Dragger.prototype.on = function (eventName, listener) {
  this._emitter.on(eventName, listener);
};

/**
 * Unbind drag event listeners.
 *
 * @public
 * @param {String} eventName
 *   - 'start', 'move', 'cancel' or 'end'.
 * @param {Function} listener
 */
Dragger.prototype.off = function (eventName, listener) {
  this._emitter.off(eventName, listener);
};

/**
 * Destroy the instance and unbind all drag event listeners.
 *
 * @public
 */
Dragger.prototype.destroy = function () {
  if (this._isDestroyed) return;

  var element = this._element;

  if (this._edgeHack) this._edgeHack.destroy();

  // Reset data and deactivate the instance.
  this._reset();

  // Destroy emitter.
  this._emitter.destroy();

  // Unbind event handlers.
  element.removeEventListener(Dragger._inputEvents.start, this._onStart, listenerOptions);
  element.removeEventListener('dragstart', Dragger._preventDefault, false);
  element.removeEventListener(Dragger._touchEvents.start, Dragger._preventDefault, true);

  // Reset styles.
  for (var prop in this._cssProps) {
    element.style[prop] = this._cssProps[prop];
    delete this._cssProps[prop];
  }

  // Reset data.
  this._element = null;

  // Mark as destroyed.
  this._isDestroyed = true;
};

var dt = 1000 / 60;

var raf = (
  window.requestAnimationFrame ||
  window.webkitRequestAnimationFrame ||
  window.mozRequestAnimationFrame ||
  window.msRequestAnimationFrame ||
  function (callback) {
    return this.setTimeout(function () {
      callback(Date.now());
    }, dt);
  }
).bind(window);

/**
 * A ticker system for handling DOM reads and writes in an efficient way.
 *
 * @class
 */
function Ticker(numLanes) {
  this._nextStep = null;
  this._lanes = [];
  this._stepQueue = [];
  this._stepCallbacks = {};
  this._step = this._step.bind(this);
  for (var i = 0; i < numLanes; i++) {
    this._lanes.push(new TickerLane());
  }
}

Ticker.prototype._step = function (time) {
  var lanes = this._lanes;
  var stepQueue = this._stepQueue;
  var stepCallbacks = this._stepCallbacks;
  var i, j, id, laneQueue, laneCallbacks, laneIndices;

  this._nextStep = null;

  for (i = 0; i < lanes.length; i++) {
    laneQueue = lanes[i].queue;
    laneCallbacks = lanes[i].callbacks;
    laneIndices = lanes[i].indices;
    for (j = 0; j < laneQueue.length; j++) {
      id = laneQueue[j];
      if (!id) continue;
      stepQueue.push(id);
      stepCallbacks[id] = laneCallbacks[id];
      delete laneCallbacks[id];
      delete laneIndices[id];
    }
    laneQueue.length = 0;
  }

  for (i = 0; i < stepQueue.length; i++) {
    id = stepQueue[i];
    if (stepCallbacks[id]) stepCallbacks[id](time);
    delete stepCallbacks[id];
  }

  stepQueue.length = 0;
};

Ticker.prototype.add = function (laneIndex, id, callback) {
  this._lanes[laneIndex].add(id, callback);
  if (!this._nextStep) this._nextStep = raf(this._step);
};

Ticker.prototype.remove = function (laneIndex, id) {
  this._lanes[laneIndex].remove(id);
};

/**
 * A lane for ticker.
 *
 * @class
 */
function TickerLane() {
  this.queue = [];
  this.indices = {};
  this.callbacks = {};
}

TickerLane.prototype.add = function (id, callback) {
  var index = this.indices[id];
  if (index !== undefined) this.queue[index] = undefined;
  this.queue.push(id);
  this.callbacks[id] = callback;
  this.indices[id] = this.queue.length - 1;
};

TickerLane.prototype.remove = function (id) {
  var index = this.indices[id];
  if (index === undefined) return;
  this.queue[index] = undefined;
  delete this.callbacks[id];
  delete this.indices[id];
};

var LAYOUT_READ = 'layoutRead';
var LAYOUT_WRITE = 'layoutWrite';
var VISIBILITY_READ = 'visibilityRead';
var VISIBILITY_WRITE = 'visibilityWrite';
var DRAG_START_READ = 'dragStartRead';
var DRAG_START_WRITE = 'dragStartWrite';
var DRAG_MOVE_READ = 'dragMoveRead';
var DRAG_MOVE_WRITE = 'dragMoveWrite';
var DRAG_SCROLL_READ = 'dragScrollRead';
var DRAG_SCROLL_WRITE = 'dragScrollWrite';
var DRAG_SORT_READ = 'dragSortRead';
var PLACEHOLDER_LAYOUT_READ = 'placeholderLayoutRead';
var PLACEHOLDER_LAYOUT_WRITE = 'placeholderLayoutWrite';
var PLACEHOLDER_RESIZE_WRITE = 'placeholderResizeWrite';
var AUTO_SCROLL_READ = 'autoScrollRead';
var AUTO_SCROLL_WRITE = 'autoScrollWrite';
var DEBOUNCE_READ = 'debounceRead';

var LANE_READ = 0;
var LANE_READ_TAIL = 1;
var LANE_WRITE = 2;

var ticker = new Ticker(3);

function addLayoutTick(itemId, read, write) {
  ticker.add(LANE_READ, LAYOUT_READ + itemId, read);
  ticker.add(LANE_WRITE, LAYOUT_WRITE + itemId, write);
}

function cancelLayoutTick(itemId) {
  ticker.remove(LANE_READ, LAYOUT_READ + itemId);
  ticker.remove(LANE_WRITE, LAYOUT_WRITE + itemId);
}

function addVisibilityTick(itemId, read, write) {
  ticker.add(LANE_READ, VISIBILITY_READ + itemId, read);
  ticker.add(LANE_WRITE, VISIBILITY_WRITE + itemId, write);
}

function cancelVisibilityTick(itemId) {
  ticker.remove(LANE_READ, VISIBILITY_READ + itemId);
  ticker.remove(LANE_WRITE, VISIBILITY_WRITE + itemId);
}

function addDragStartTick(itemId, read, write) {
  ticker.add(LANE_READ, DRAG_START_READ + itemId, read);
  ticker.add(LANE_WRITE, DRAG_START_WRITE + itemId, write);
}

function cancelDragStartTick(itemId) {
  ticker.remove(LANE_READ, DRAG_START_READ + itemId);
  ticker.remove(LANE_WRITE, DRAG_START_WRITE + itemId);
}

function addDragMoveTick(itemId, read, write) {
  ticker.add(LANE_READ, DRAG_MOVE_READ + itemId, read);
  ticker.add(LANE_WRITE, DRAG_MOVE_WRITE + itemId, write);
}

function cancelDragMoveTick(itemId) {
  ticker.remove(LANE_READ, DRAG_MOVE_READ + itemId);
  ticker.remove(LANE_WRITE, DRAG_MOVE_WRITE + itemId);
}

function addDragScrollTick(itemId, read, write) {
  ticker.add(LANE_READ, DRAG_SCROLL_READ + itemId, read);
  ticker.add(LANE_WRITE, DRAG_SCROLL_WRITE + itemId, write);
}

function cancelDragScrollTick(itemId) {
  ticker.remove(LANE_READ, DRAG_SCROLL_READ + itemId);
  ticker.remove(LANE_WRITE, DRAG_SCROLL_WRITE + itemId);
}

function addDragSortTick(itemId, read) {
  ticker.add(LANE_READ_TAIL, DRAG_SORT_READ + itemId, read);
}

function cancelDragSortTick(itemId) {
  ticker.remove(LANE_READ_TAIL, DRAG_SORT_READ + itemId);
}

function addPlaceholderLayoutTick(itemId, read, write) {
  ticker.add(LANE_READ, PLACEHOLDER_LAYOUT_READ + itemId, read);
  ticker.add(LANE_WRITE, PLACEHOLDER_LAYOUT_WRITE + itemId, write);
}

function cancelPlaceholderLayoutTick(itemId) {
  ticker.remove(LANE_READ, PLACEHOLDER_LAYOUT_READ + itemId);
  ticker.remove(LANE_WRITE, PLACEHOLDER_LAYOUT_WRITE + itemId);
}

function addPlaceholderResizeTick(itemId, write) {
  ticker.add(LANE_WRITE, PLACEHOLDER_RESIZE_WRITE + itemId, write);
}

function cancelPlaceholderResizeTick(itemId) {
  ticker.remove(LANE_WRITE, PLACEHOLDER_RESIZE_WRITE + itemId);
}

function addAutoScrollTick(read, write) {
  ticker.add(LANE_READ, AUTO_SCROLL_READ, read);
  ticker.add(LANE_WRITE, AUTO_SCROLL_WRITE, write);
}

function cancelAutoScrollTick() {
  ticker.remove(LANE_READ, AUTO_SCROLL_READ);
  ticker.remove(LANE_WRITE, AUTO_SCROLL_WRITE);
}

function addDebounceTick(debounceId, read) {
  ticker.add(LANE_READ, DEBOUNCE_READ + debounceId, read);
}

function cancelDebounceTick(debounceId) {
  ticker.remove(LANE_READ, DEBOUNCE_READ + debounceId);
}

var AXIS_X = 1;
var AXIS_Y = 2;
var FORWARD = 4;
var BACKWARD = 8;
var LEFT = AXIS_X | BACKWARD;
var RIGHT = AXIS_X | FORWARD;
var UP = AXIS_Y | BACKWARD;
var DOWN = AXIS_Y | FORWARD;

var functionType = 'function';

/**
 * Check if a value is a function.
 *
 * @param {*} val
 * @returns {Boolean}
 */
function isFunction(val) {
  return typeof val === functionType;
}

var cache$1 = typeof WeakMap === 'function' ? new WeakMap() : null;

/**
 * Returns the computed value of an element's style property as a string.
 *
 * @param {HTMLElement} element
 * @param {String} style
 * @returns {String}
 */
function getStyle(element, style) {
  var styles = cache$1 && cache$1.get(element);

  if (!styles) {
    styles = window.getComputedStyle(element, null);
    if (cache$1) cache$1.set(element, styles);
  }

  return styles.getPropertyValue(style);
}

/**
 * Returns the computed value of an element's style property transformed into
 * a float value.
 *
 * @param {HTMLElement} el
 * @param {String} style
 * @returns {Number}
 */
function getStyleAsFloat(el, style) {
  return parseFloat(getStyle(el, style)) || 0;
}

var DOC_ELEM = document.documentElement;
var BODY = document.body;
var THRESHOLD_DATA = { value: 0, offset: 0 };

/**
 * @param {HTMLElement|Window} element
 * @returns {HTMLElement|Window}
 */
function getScrollElement(element) {
  if (element === window || element === DOC_ELEM || element === BODY) {
    return window;
  } else {
    return element;
  }
}

/**
 * @param {HTMLElement|Window} element
 * @returns {Number}
 */
function getScrollLeft(element) {
  return element === window ? element.pageXOffset : element.scrollLeft;
}

/**
 * @param {HTMLElement|Window} element
 * @returns {Number}
 */
function getScrollTop(element) {
  return element === window ? element.pageYOffset : element.scrollTop;
}

/**
 * @param {HTMLElement|Window} element
 * @returns {Number}
 */
function getScrollLeftMax(element) {
  if (element === window) {
    return DOC_ELEM.scrollWidth - DOC_ELEM.clientWidth;
  } else {
    return element.scrollWidth - element.clientWidth;
  }
}

/**
 * @param {HTMLElement|Window} element
 * @returns {Number}
 */
function getScrollTopMax(element) {
  if (element === window) {
    return DOC_ELEM.scrollHeight - DOC_ELEM.clientHeight;
  } else {
    return element.scrollHeight - element.clientHeight;
  }
}

/**
 * Get window's or element's client rectangle data relative to the element's
 * content dimensions (includes inner size + padding, excludes scrollbars,
 * borders and margins).
 *
 * @param {HTMLElement|Window} element
 * @returns {Rectangle}
 */
function getContentRect(element, result) {
  result = result || {};

  if (element === window) {
    result.width = DOC_ELEM.clientWidth;
    result.height = DOC_ELEM.clientHeight;
    result.left = 0;
    result.right = result.width;
    result.top = 0;
    result.bottom = result.height;
  } else {
    var bcr = element.getBoundingClientRect();
    var borderLeft = element.clientLeft || getStyleAsFloat(element, 'border-left-width');
    var borderTop = element.clientTop || getStyleAsFloat(element, 'border-top-width');
    result.width = element.clientWidth;
    result.height = element.clientHeight;
    result.left = bcr.left + borderLeft;
    result.right = result.left + result.width;
    result.top = bcr.top + borderTop;
    result.bottom = result.top + result.height;
  }

  return result;
}

/**
 * @param {Item} item
 * @returns {Object}
 */
function getItemAutoScrollSettings(item) {
  return item._drag._getGrid()._settings.dragAutoScroll;
}

/**
 * @param {Item} item
 */
function prepareItemScrollSync(item) {
  if (!item._drag) return;
  item._drag._prepareScroll();
}

/**
 * @param {Item} item
 */
function applyItemScrollSync(item) {
  if (!item._drag || !item._isActive) return;
  var drag = item._drag;
  drag._scrollDiffX = drag._scrollDiffY = 0;
  item._setTranslate(drag._left, drag._top);
}

/**
 * Compute threshold value and edge offset.
 *
 * @param {Number} threshold
 * @param {Number} safeZone
 * @param {Number} itemSize
 * @param {Number} targetSize
 * @returns {Object}
 */
function computeThreshold(threshold, safeZone, itemSize, targetSize) {
  THRESHOLD_DATA.value = Math.min(targetSize / 2, threshold);
  THRESHOLD_DATA.offset =
    Math.max(0, itemSize + THRESHOLD_DATA.value * 2 + targetSize * safeZone - targetSize) / 2;
  return THRESHOLD_DATA;
}

function ScrollRequest() {
  this.reset();
}

ScrollRequest.prototype.reset = function () {
  if (this.isActive) this.onStop();
  this.item = null;
  this.element = null;
  this.isActive = false;
  this.isEnding = false;
  this.direction = null;
  this.value = null;
  this.maxValue = 0;
  this.threshold = 0;
  this.distance = 0;
  this.speed = 0;
  this.duration = 0;
  this.action = null;
};

ScrollRequest.prototype.hasReachedEnd = function () {
  return FORWARD & this.direction ? this.value >= this.maxValue : this.value <= 0;
};

ScrollRequest.prototype.computeCurrentScrollValue = function () {
  if (this.value === null) {
    return AXIS_X & this.direction ? getScrollLeft(this.element) : getScrollTop(this.element);
  }
  return Math.max(0, Math.min(this.value, this.maxValue));
};

ScrollRequest.prototype.computeNextScrollValue = function (deltaTime) {
  var delta = this.speed * (deltaTime / 1000);
  var nextValue = FORWARD & this.direction ? this.value + delta : this.value - delta;
  return Math.max(0, Math.min(nextValue, this.maxValue));
};

ScrollRequest.prototype.computeSpeed = (function () {
  var data = {
    direction: null,
    threshold: 0,
    distance: 0,
    value: 0,
    maxValue: 0,
    deltaTime: 0,
    duration: 0,
    isEnding: false,
  };

  return function (deltaTime) {
    var item = this.item;
    var speed = getItemAutoScrollSettings(item).speed;

    if (isFunction(speed)) {
      data.direction = this.direction;
      data.threshold = this.threshold;
      data.distance = this.distance;
      data.value = this.value;
      data.maxValue = this.maxValue;
      data.duration = this.duration;
      data.speed = this.speed;
      data.deltaTime = deltaTime;
      data.isEnding = this.isEnding;
      return speed(item, this.element, data);
    } else {
      return speed;
    }
  };
})();

ScrollRequest.prototype.tick = function (deltaTime) {
  if (!this.isActive) {
    this.isActive = true;
    this.onStart();
  }
  this.value = this.computeCurrentScrollValue();
  this.speed = this.computeSpeed(deltaTime);
  this.value = this.computeNextScrollValue(deltaTime);
  this.duration += deltaTime;
  return this.value;
};

ScrollRequest.prototype.onStart = function () {
  var item = this.item;
  var onStart = getItemAutoScrollSettings(item).onStart;
  if (isFunction(onStart)) onStart(item, this.element, this.direction);
};

ScrollRequest.prototype.onStop = function () {
  var item = this.item;
  var onStop = getItemAutoScrollSettings(item).onStop;
  if (isFunction(onStop)) onStop(item, this.element, this.direction);
  // Manually nudge sort to happen. There's a good chance that the item is still
  // after the scroll stops which means that the next sort will be triggered
  // only after the item is moved or it's parent scrolled.
  if (item._drag) item._drag.sort();
};

function ScrollAction() {
  this.element = null;
  this.requestX = null;
  this.requestY = null;
  this.scrollLeft = 0;
  this.scrollTop = 0;
}

ScrollAction.prototype.reset = function () {
  if (this.requestX) this.requestX.action = null;
  if (this.requestY) this.requestY.action = null;
  this.element = null;
  this.requestX = null;
  this.requestY = null;
  this.scrollLeft = 0;
  this.scrollTop = 0;
};

ScrollAction.prototype.addRequest = function (request) {
  if (AXIS_X & request.direction) {
    this.removeRequest(this.requestX);
    this.requestX = request;
  } else {
    this.removeRequest(this.requestY);
    this.requestY = request;
  }
  request.action = this;
};

ScrollAction.prototype.removeRequest = function (request) {
  if (!request) return;
  if (this.requestX === request) {
    this.requestX = null;
    request.action = null;
  } else if (this.requestY === request) {
    this.requestY = null;
    request.action = null;
  }
};

ScrollAction.prototype.computeScrollValues = function () {
  this.scrollLeft = this.requestX ? this.requestX.value : getScrollLeft(this.element);
  this.scrollTop = this.requestY ? this.requestY.value : getScrollTop(this.element);
};

ScrollAction.prototype.scroll = function () {
  var element = this.element;
  if (!element) return;

  if (element.scrollTo) {
    element.scrollTo(this.scrollLeft, this.scrollTop);
  } else {
    element.scrollLeft = this.scrollLeft;
    element.scrollTop = this.scrollTop;
  }
};

function Pool(createItem, releaseItem) {
  this.pool = [];
  this.createItem = createItem;
  this.releaseItem = releaseItem;
}

Pool.prototype.pick = function () {
  return this.pool.pop() || this.createItem();
};

Pool.prototype.release = function (item) {
  this.releaseItem(item);
  if (this.pool.indexOf(item) !== -1) return;
  this.pool.push(item);
};

Pool.prototype.reset = function () {
  this.pool.length = 0;
};

/**
 * Check if two rectangles are overlapping.
 *
 * @param {Object} a
 * @param {Object} b
 * @returns {Number}
 */
function isOverlapping(a, b) {
  return !(
    a.left + a.width <= b.left ||
    b.left + b.width <= a.left ||
    a.top + a.height <= b.top ||
    b.top + b.height <= a.top
  );
}

/**
 * Calculate intersection area between two rectangle.
 *
 * @param {Object} a
 * @param {Object} b
 * @returns {Number}
 */
function getIntersectionArea(a, b) {
  if (!isOverlapping(a, b)) return 0;
  var width = Math.min(a.left + a.width, b.left + b.width) - Math.max(a.left, b.left);
  var height = Math.min(a.top + a.height, b.top + b.height) - Math.max(a.top, b.top);
  return width * height;
}

/**
 * Calculate how many percent the intersection area of two rectangles is from
 * the maximum potential intersection area between the rectangles.
 *
 * @param {Object} a
 * @param {Object} b
 * @returns {Number}
 */
function getIntersectionScore(a, b) {
  var area = getIntersectionArea(a, b);
  if (!area) return 0;
  var maxArea = Math.min(a.width, b.width) * Math.min(a.height, b.height);
  return (area / maxArea) * 100;
}

var RECT_1 = {
  width: 0,
  height: 0,
  left: 0,
  right: 0,
  top: 0,
  bottom: 0,
};

var RECT_2 = {
  width: 0,
  height: 0,
  left: 0,
  right: 0,
  top: 0,
  bottom: 0,
};

function AutoScroller() {
  this._isDestroyed = false;
  this._isTicking = false;
  this._tickTime = 0;
  this._tickDeltaTime = 0;
  this._items = [];
  this._actions = [];
  this._requests = {};
  this._requests[AXIS_X] = {};
  this._requests[AXIS_Y] = {};
  this._requestOverlapCheck = {};
  this._dragPositions = {};
  this._dragDirections = {};
  this._overlapCheckInterval = 150;

  this._requestPool = new Pool(
    function () {
      return new ScrollRequest();
    },
    function (request) {
      request.reset();
    }
  );

  this._actionPool = new Pool(
    function () {
      return new ScrollAction();
    },
    function (action) {
      action.reset();
    }
  );

  this._readTick = this._readTick.bind(this);
  this._writeTick = this._writeTick.bind(this);
}

AutoScroller.AXIS_X = AXIS_X;
AutoScroller.AXIS_Y = AXIS_Y;
AutoScroller.FORWARD = FORWARD;
AutoScroller.BACKWARD = BACKWARD;
AutoScroller.LEFT = LEFT;
AutoScroller.RIGHT = RIGHT;
AutoScroller.UP = UP;
AutoScroller.DOWN = DOWN;

AutoScroller.smoothSpeed = function (maxSpeed, acceleration, deceleration) {
  return function (item, element, data) {
    var targetSpeed = 0;
    if (!data.isEnding) {
      if (data.threshold > 0) {
        var factor = data.threshold - Math.max(0, data.distance);
        targetSpeed = (maxSpeed / data.threshold) * factor;
      } else {
        targetSpeed = maxSpeed;
      }
    }

    var currentSpeed = data.speed;
    var nextSpeed = targetSpeed;

    if (currentSpeed === targetSpeed) {
      return nextSpeed;
    }

    if (currentSpeed < targetSpeed) {
      nextSpeed = currentSpeed + acceleration * (data.deltaTime / 1000);
      return Math.min(targetSpeed, nextSpeed);
    } else {
      nextSpeed = currentSpeed - deceleration * (data.deltaTime / 1000);
      return Math.max(targetSpeed, nextSpeed);
    }
  };
};

AutoScroller.pointerHandle = function (pointerSize) {
  var rect = { left: 0, top: 0, width: 0, height: 0 };
  var size = pointerSize || 1;
  return function (item, x, y, w, h, pX, pY) {
    rect.left = pX - size * 0.5;
    rect.top = pY - size * 0.5;
    rect.width = size;
    rect.height = size;
    return rect;
  };
};

AutoScroller.prototype._readTick = function (time) {
  if (this._isDestroyed) return;
  if (time && this._tickTime) {
    this._tickDeltaTime = time - this._tickTime;
    this._tickTime = time;
    this._updateRequests();
    this._updateActions();
  } else {
    this._tickTime = time;
    this._tickDeltaTime = 0;
  }
};

AutoScroller.prototype._writeTick = function () {
  if (this._isDestroyed) return;
  this._applyActions();
  addAutoScrollTick(this._readTick, this._writeTick);
};

AutoScroller.prototype._startTicking = function () {
  this._isTicking = true;
  addAutoScrollTick(this._readTick, this._writeTick);
};

AutoScroller.prototype._stopTicking = function () {
  this._isTicking = false;
  this._tickTime = 0;
  this._tickDeltaTime = 0;
  cancelAutoScrollTick();
};

AutoScroller.prototype._getItemHandleRect = function (item, handle, rect) {
  var itemDrag = item._drag;

  if (handle) {
    var ev = itemDrag._dragMoveEvent || itemDrag._dragStartEvent;
    var data = handle(
      item,
      itemDrag._clientX,
      itemDrag._clientY,
      item._width,
      item._height,
      ev.clientX,
      ev.clientY
    );
    rect.left = data.left;
    rect.top = data.top;
    rect.width = data.width;
    rect.height = data.height;
  } else {
    rect.left = itemDrag._clientX;
    rect.top = itemDrag._clientY;
    rect.width = item._width;
    rect.height = item._height;
  }

  rect.right = rect.left + rect.width;
  rect.bottom = rect.top + rect.height;

  return rect;
};

AutoScroller.prototype._requestItemScroll = function (
  item,
  axis,
  element,
  direction,
  threshold,
  distance,
  maxValue
) {
  var reqMap = this._requests[axis];
  var request = reqMap[item._id];

  if (request) {
    if (request.element !== element || request.direction !== direction) {
      request.reset();
    }
  } else {
    request = this._requestPool.pick();
  }

  request.item = item;
  request.element = element;
  request.direction = direction;
  request.threshold = threshold;
  request.distance = distance;
  request.maxValue = maxValue;
  reqMap[item._id] = request;
};

AutoScroller.prototype._cancelItemScroll = function (item, axis) {
  var reqMap = this._requests[axis];
  var request = reqMap[item._id];
  if (!request) return;
  if (request.action) request.action.removeRequest(request);
  this._requestPool.release(request);
  delete reqMap[item._id];
};

AutoScroller.prototype._checkItemOverlap = function (item, checkX, checkY) {
  var settings = getItemAutoScrollSettings(item);
  var targets = isFunction(settings.targets) ? settings.targets(item) : settings.targets;
  var threshold = settings.threshold;
  var safeZone = settings.safeZone;

  if (!targets || !targets.length) {
    checkX && this._cancelItemScroll(item, AXIS_X);
    checkY && this._cancelItemScroll(item, AXIS_Y);
    return;
  }

  var dragDirections = this._dragDirections[item._id];
  var dragDirectionX = dragDirections[0];
  var dragDirectionY = dragDirections[1];

  if (!dragDirectionX && !dragDirectionY) {
    checkX && this._cancelItemScroll(item, AXIS_X);
    checkY && this._cancelItemScroll(item, AXIS_Y);
    return;
  }

  var itemRect = this._getItemHandleRect(item, settings.handle, RECT_1);
  var testRect = RECT_2;

  var target = null;
  var testElement = null;
  var testAxisX = true;
  var testAxisY = true;
  var testScore = 0;
  var testPriority = 0;
  var testThreshold = null;
  var testDirection = null;
  var testDistance = 0;
  var testMaxScrollX = 0;
  var testMaxScrollY = 0;

  var xElement = null;
  var xPriority = -Infinity;
  var xThreshold = 0;
  var xScore = 0;
  var xDirection = null;
  var xDistance = 0;
  var xMaxScroll = 0;

  var yElement = null;
  var yPriority = -Infinity;
  var yThreshold = 0;
  var yScore = 0;
  var yDirection = null;
  var yDistance = 0;
  var yMaxScroll = 0;

  for (var i = 0; i < targets.length; i++) {
    target = targets[i];
    testAxisX = checkX && dragDirectionX && target.axis !== AXIS_Y;
    testAxisY = checkY && dragDirectionY && target.axis !== AXIS_X;
    testPriority = target.priority || 0;

    // Ignore this item if it's x-axis and y-axis priority is lower than
    // the currently matching item's.
    if ((!testAxisX || testPriority < xPriority) && (!testAxisY || testPriority < yPriority)) {
      continue;
    }

    testElement = getScrollElement(target.element || target);
    testMaxScrollX = testAxisX ? getScrollLeftMax(testElement) : -1;
    testMaxScrollY = testAxisY ? getScrollTopMax(testElement) : -1;

    // Ignore this item if there is no possibility to scroll.
    if (!testMaxScrollX && !testMaxScrollY) continue;

    testRect = getContentRect(testElement, testRect);
    testScore = getIntersectionScore(itemRect, testRect);

    // Ignore this item if it's not overlapping at all with the dragged item.
    if (testScore <= 0) continue;

    // Test x-axis.
    if (
      testAxisX &&
      testPriority >= xPriority &&
      testMaxScrollX > 0 &&
      (testPriority > xPriority || testScore > xScore)
    ) {
      testDirection = null;
      testThreshold = computeThreshold(
        typeof target.threshold === 'number' ? target.threshold : threshold,
        safeZone,
        itemRect.width,
        testRect.width
      );
      if (dragDirectionX === RIGHT) {
        testDistance = testRect.right + testThreshold.offset - itemRect.right;
        if (testDistance <= testThreshold.value && getScrollLeft(testElement) < testMaxScrollX) {
          testDirection = RIGHT;
        }
      } else if (dragDirectionX === LEFT) {
        testDistance = itemRect.left - (testRect.left - testThreshold.offset);
        if (testDistance <= testThreshold.value && getScrollLeft(testElement) > 0) {
          testDirection = LEFT;
        }
      }

      if (testDirection !== null) {
        xElement = testElement;
        xPriority = testPriority;
        xThreshold = testThreshold.value;
        xScore = testScore;
        xDirection = testDirection;
        xDistance = testDistance;
        xMaxScroll = testMaxScrollX;
      }
    }

    // Test y-axis.
    if (
      testAxisY &&
      testPriority >= yPriority &&
      testMaxScrollY > 0 &&
      (testPriority > yPriority || testScore > yScore)
    ) {
      testDirection = null;
      testThreshold = computeThreshold(
        typeof target.threshold === 'number' ? target.threshold : threshold,
        safeZone,
        itemRect.height,
        testRect.height
      );
      if (dragDirectionY === DOWN) {
        testDistance = testRect.bottom + testThreshold.offset - itemRect.bottom;
        if (testDistance <= testThreshold.value && getScrollTop(testElement) < testMaxScrollY) {
          testDirection = DOWN;
        }
      } else if (dragDirectionY === UP) {
        testDistance = itemRect.top - (testRect.top - testThreshold.offset);
        if (testDistance <= testThreshold.value && getScrollTop(testElement) > 0) {
          testDirection = UP;
        }
      }

      if (testDirection !== null) {
        yElement = testElement;
        yPriority = testPriority;
        yThreshold = testThreshold.value;
        yScore = testScore;
        yDirection = testDirection;
        yDistance = testDistance;
        yMaxScroll = testMaxScrollY;
      }
    }
  }

  // Request or cancel x-axis scroll.
  if (checkX) {
    if (xElement) {
      this._requestItemScroll(
        item,
        AXIS_X,
        xElement,
        xDirection,
        xThreshold,
        xDistance,
        xMaxScroll
      );
    } else {
      this._cancelItemScroll(item, AXIS_X);
    }
  }

  // Request or cancel y-axis scroll.
  if (checkY) {
    if (yElement) {
      this._requestItemScroll(
        item,
        AXIS_Y,
        yElement,
        yDirection,
        yThreshold,
        yDistance,
        yMaxScroll
      );
    } else {
      this._cancelItemScroll(item, AXIS_Y);
    }
  }
};

AutoScroller.prototype._updateScrollRequest = function (scrollRequest) {
  var item = scrollRequest.item;
  var settings = getItemAutoScrollSettings(item);
  var targets = isFunction(settings.targets) ? settings.targets(item) : settings.targets;
  var targetCount = (targets && targets.length) || 0;
  var threshold = settings.threshold;
  var safeZone = settings.safeZone;
  var itemRect = this._getItemHandleRect(item, settings.handle, RECT_1);
  var testRect = RECT_2;
  var target = null;
  var testElement = null;
  var testIsAxisX = false;
  var testScore = null;
  var testThreshold = null;
  var testDistance = null;
  var testScroll = null;
  var testMaxScroll = null;
  var hasReachedEnd = null;

  for (var i = 0; i < targetCount; i++) {
    target = targets[i];

    // Make sure we have a matching element.
    testElement = getScrollElement(target.element || target);
    if (testElement !== scrollRequest.element) continue;

    // Make sure we have a matching axis.
    testIsAxisX = !!(AXIS_X & scrollRequest.direction);
    if (testIsAxisX) {
      if (target.axis === AXIS_Y) continue;
    } else {
      if (target.axis === AXIS_X) continue;
    }

    // Stop scrolling if there is no room to scroll anymore.
    testMaxScroll = testIsAxisX ? getScrollLeftMax(testElement) : getScrollTopMax(testElement);
    if (testMaxScroll <= 0) {
      break;
    }

    testRect = getContentRect(testElement, testRect);
    testScore = getIntersectionScore(itemRect, testRect);

    // Stop scrolling if dragged item is not overlapping with the scroll
    // element anymore.
    if (testScore <= 0) {
      break;
    }

    // Compute threshold and edge offset.
    testThreshold = computeThreshold(
      typeof target.threshold === 'number' ? target.threshold : threshold,
      safeZone,
      testIsAxisX ? itemRect.width : itemRect.height,
      testIsAxisX ? testRect.width : testRect.height
    );

    // Compute distance (based on current direction).
    if (scrollRequest.direction === LEFT) {
      testDistance = itemRect.left - (testRect.left - testThreshold.offset);
    } else if (scrollRequest.direction === RIGHT) {
      testDistance = testRect.right + testThreshold.offset - itemRect.right;
    } else if (scrollRequest.direction === UP) {
      testDistance = itemRect.top - (testRect.top - testThreshold.offset);
    } else {
      testDistance = testRect.bottom + testThreshold.offset - itemRect.bottom;
    }

    // Stop scrolling if threshold is not exceeded.
    if (testDistance > testThreshold.value) {
      break;
    }

    // Stop scrolling if we have reached the end of the scroll value.
    testScroll = testIsAxisX ? getScrollLeft(testElement) : getScrollTop(testElement);
    hasReachedEnd =
      FORWARD & scrollRequest.direction ? testScroll >= testMaxScroll : testScroll <= 0;
    if (hasReachedEnd) {
      break;
    }

    // Scrolling can continue, let's update the values.
    scrollRequest.maxValue = testMaxScroll;
    scrollRequest.threshold = testThreshold.value;
    scrollRequest.distance = testDistance;
    scrollRequest.isEnding = false;
    return true;
  }

  // Before we end the request, let's see if we need to stop the scrolling
  // smoothly or immediately.
  if (settings.smoothStop === true && scrollRequest.speed > 0) {
    if (hasReachedEnd === null) hasReachedEnd = scrollRequest.hasReachedEnd();
    scrollRequest.isEnding = hasReachedEnd ? false : true;
  } else {
    scrollRequest.isEnding = false;
  }

  return scrollRequest.isEnding;
};

AutoScroller.prototype._updateRequests = function () {
  var items = this._items;
  var requestsX = this._requests[AXIS_X];
  var requestsY = this._requests[AXIS_Y];
  var item, reqX, reqY, checkTime, needsCheck, checkX, checkY;

  for (var i = 0; i < items.length; i++) {
    item = items[i];
    checkTime = this._requestOverlapCheck[item._id];
    needsCheck = checkTime > 0 && this._tickTime - checkTime > this._overlapCheckInterval;

    checkX = true;
    reqX = requestsX[item._id];
    if (reqX && reqX.isActive) {
      checkX = !this._updateScrollRequest(reqX);
      if (checkX) {
        needsCheck = true;
        this._cancelItemScroll(item, AXIS_X);
      }
    }

    checkY = true;
    reqY = requestsY[item._id];
    if (reqY && reqY.isActive) {
      checkY = !this._updateScrollRequest(reqY);
      if (checkY) {
        needsCheck = true;
        this._cancelItemScroll(item, AXIS_Y);
      }
    }

    if (needsCheck) {
      this._requestOverlapCheck[item._id] = 0;
      this._checkItemOverlap(item, checkX, checkY);
    }
  }
};

AutoScroller.prototype._requestAction = function (request, axis) {
  var actions = this._actions;
  var isAxisX = axis === AXIS_X;
  var action = null;

  for (var i = 0; i < actions.length; i++) {
    action = actions[i];

    // If the action's request does not match the request's -> skip.
    if (request.element !== action.element) {
      action = null;
      continue;
    }

    // If the request and action share the same element, but the request slot
    // for the requested axis is already reserved let's ignore and cancel this
    // request.
    if (isAxisX ? action.requestX : action.requestY) {
      this._cancelItemScroll(request.item, axis);
      return;
    }

    // Seems like we have found our action, let's break the loop.
    break;
  }

  if (!action) action = this._actionPool.pick();
  action.element = request.element;
  action.addRequest(request);

  request.tick(this._tickDeltaTime);
  actions.push(action);
};

AutoScroller.prototype._updateActions = function () {
  var items = this._items;
  var requests = this._requests;
  var actions = this._actions;
  var itemId;
  var reqX;
  var reqY;
  var i;

  // Generate actions.
  for (i = 0; i < items.length; i++) {
    itemId = items[i]._id;
    reqX = requests[AXIS_X][itemId];
    reqY = requests[AXIS_Y][itemId];
    if (reqX) this._requestAction(reqX, AXIS_X);
    if (reqY) this._requestAction(reqY, AXIS_Y);
  }

  // Compute actions' scroll values.
  for (i = 0; i < actions.length; i++) {
    actions[i].computeScrollValues();
  }
};

AutoScroller.prototype._applyActions = function () {
  var actions = this._actions;
  var items = this._items;
  var i;

  // No actions -> no scrolling.
  if (!actions.length) return;

  // Scroll all the required elements.
  for (i = 0; i < actions.length; i++) {
    actions[i].scroll();
    this._actionPool.release(actions[i]);
  }

  // Reset actions.
  actions.length = 0;

  // Sync the item position immediately after all the auto-scrolling business is
  // finished. Without this procedure the items will jitter during auto-scroll
  // (in some cases at least) since the drag scroll handler is async (bound to
  // raf tick). Note that this procedure should not emit any dragScroll events,
  // because otherwise they would be emitted twice for the same event.
  for (i = 0; i < items.length; i++) prepareItemScrollSync(items[i]);
  for (i = 0; i < items.length; i++) applyItemScrollSync(items[i]);
};

AutoScroller.prototype._updateDragDirection = function (item) {
  var dragPositions = this._dragPositions[item._id];
  var dragDirections = this._dragDirections[item._id];
  var x1 = item._drag._left;
  var y1 = item._drag._top;
  if (dragPositions.length) {
    var x2 = dragPositions[0];
    var y2 = dragPositions[1];
    dragDirections[0] = x1 > x2 ? RIGHT : x1 < x2 ? LEFT : dragDirections[0] || 0;
    dragDirections[1] = y1 > y2 ? DOWN : y1 < y2 ? UP : dragDirections[1] || 0;
  }
  dragPositions[0] = x1;
  dragPositions[1] = y1;
};

AutoScroller.prototype.addItem = function (item) {
  if (this._isDestroyed) return;
  var index = this._items.indexOf(item);
  if (index === -1) {
    this._items.push(item);
    this._requestOverlapCheck[item._id] = this._tickTime;
    this._dragDirections[item._id] = [0, 0];
    this._dragPositions[item._id] = [];
    if (!this._isTicking) this._startTicking();
  }
};

AutoScroller.prototype.updateItem = function (item) {
  if (this._isDestroyed) return;

  // Make sure the item still exists in the auto-scroller.
  if (!this._dragDirections[item._id]) return;

  this._updateDragDirection(item);
  if (!this._requestOverlapCheck[item._id]) {
    this._requestOverlapCheck[item._id] = this._tickTime;
  }
};

AutoScroller.prototype.removeItem = function (item) {
  if (this._isDestroyed) return;

  var index = this._items.indexOf(item);
  if (index === -1) return;

  var itemId = item._id;

  var reqX = this._requests[AXIS_X][itemId];
  if (reqX) {
    this._cancelItemScroll(item, AXIS_X);
    delete this._requests[AXIS_X][itemId];
  }

  var reqY = this._requests[AXIS_Y][itemId];
  if (reqY) {
    this._cancelItemScroll(item, AXIS_Y);
    delete this._requests[AXIS_Y][itemId];
  }

  delete this._requestOverlapCheck[itemId];
  delete this._dragPositions[itemId];
  delete this._dragDirections[itemId];
  this._items.splice(index, 1);

  if (this._isTicking && !this._items.length) {
    this._stopTicking();
  }
};

AutoScroller.prototype.isItemScrollingX = function (item) {
  var reqX = this._requests[AXIS_X][item._id];
  return !!(reqX && reqX.isActive);
};

AutoScroller.prototype.isItemScrollingY = function (item) {
  var reqY = this._requests[AXIS_Y][item._id];
  return !!(reqY && reqY.isActive);
};

AutoScroller.prototype.isItemScrolling = function (item) {
  return this.isItemScrollingX(item) || this.isItemScrollingY(item);
};

AutoScroller.prototype.destroy = function () {
  if (this._isDestroyed) return;

  var items = this._items.slice(0);
  for (var i = 0; i < items.length; i++) {
    this.removeItem(items[i]);
  }

  this._actions.length = 0;
  this._requestPool.reset();
  this._actionPool.reset();

  this._isDestroyed = true;
};

var ElProto = window.Element.prototype;
var matchesFn =
  ElProto.matches ||
  ElProto.matchesSelector ||
  ElProto.webkitMatchesSelector ||
  ElProto.mozMatchesSelector ||
  ElProto.msMatchesSelector ||
  ElProto.oMatchesSelector ||
  function () {
    return false;
  };

/**
 * Check if element matches a CSS selector.
 *
 * @param {Element} el
 * @param {String} selector
 * @returns {Boolean}
 */
function elementMatches(el, selector) {
  return matchesFn.call(el, selector);
}

/**
 * Add class to an element.
 *
 * @param {HTMLElement} element
 * @param {String} className
 */
function addClass(element, className) {
  if (!className) return;

  if (element.classList) {
    element.classList.add(className);
  } else {
    if (!elementMatches(element, '.' + className)) {
      element.className += ' ' + className;
    }
  }
}

var tempArray = [];
var numberType = 'number';

/**
 * Insert an item or an array of items to array to a specified index. Mutates
 * the array. The index can be negative in which case the items will be added
 * to the end of the array.
 *
 * @param {Array} array
 * @param {*} items
 * @param {Number} [index=-1]
 */
function arrayInsert(array, items, index) {
  var startIndex = typeof index === numberType ? index : -1;
  if (startIndex < 0) startIndex = array.length - startIndex + 1;

  array.splice.apply(array, tempArray.concat(startIndex, 0, items));
  tempArray.length = 0;
}

/**
 * Normalize array index. Basically this function makes sure that the provided
 * array index is within the bounds of the provided array and also transforms
 * negative index to the matching positive index. The third (optional) argument
 * allows you to define offset for array's length in case you are adding items
 * to the array or removing items from the array.
 *
 * @param {Array} array
 * @param {Number} index
 * @param {Number} [sizeOffset]
 */
function normalizeArrayIndex(array, index, sizeOffset) {
  var maxIndex = Math.max(0, array.length - 1 + (sizeOffset || 0));
  return index > maxIndex ? maxIndex : index < 0 ? Math.max(maxIndex + index + 1, 0) : index;
}

/**
 * Move array item to another index.
 *
 * @param {Array} array
 * @param {Number} fromIndex
 *   - Index (positive or negative) of the item that will be moved.
 * @param {Number} toIndex
 *   - Index (positive or negative) where the item should be moved to.
 */
function arrayMove(array, fromIndex, toIndex) {
  // Make sure the array has two or more items.
  if (array.length < 2) return;

  // Normalize the indices.
  var from = normalizeArrayIndex(array, fromIndex);
  var to = normalizeArrayIndex(array, toIndex);

  // Add target item to the new position.
  if (from !== to) {
    array.splice(to, 0, array.splice(from, 1)[0]);
  }
}

/**
 * Swap array items.
 *
 * @param {Array} array
 * @param {Number} index
 *   - Index (positive or negative) of the item that will be swapped.
 * @param {Number} withIndex
 *   - Index (positive or negative) of the other item that will be swapped.
 */
function arraySwap(array, index, withIndex) {
  // Make sure the array has two or more items.
  if (array.length < 2) return;

  // Normalize the indices.
  var indexA = normalizeArrayIndex(array, index);
  var indexB = normalizeArrayIndex(array, withIndex);
  var temp;

  // Swap the items.
  if (indexA !== indexB) {
    temp = array[indexA];
    array[indexA] = array[indexB];
    array[indexB] = temp;
  }
}

var transformProp = getPrefixedPropName(document.documentElement.style, 'transform') || 'transform';

var styleNameRegEx = /([A-Z])/g;
var prefixRegex = /^(webkit-|moz-|ms-|o-)/;
var msPrefixRegex = /^(-m-s-)/;

/**
 * Transforms a camel case style property to kebab case style property. Handles
 * vendor prefixed properties elegantly as well, e.g. "WebkitTransform" and
 * "webkitTransform" are both transformed into "-webkit-transform".
 *
 * @param {String} property
 * @returns {String}
 */
function getStyleName(property) {
  // Initial slicing, turns "fooBarProp" into "foo-bar-prop".
  var styleName = property.replace(styleNameRegEx, '-$1').toLowerCase();

  // Handle properties that start with "webkit", "moz", "ms" or "o" prefix (we
  // need to add an extra '-' to the beginnig).
  styleName = styleName.replace(prefixRegex, '-$1');

  // Handle properties that start with "MS" prefix (we need to transform the
  // "-m-s-" into "-ms-").
  styleName = styleName.replace(msPrefixRegex, '-ms-');

  return styleName;
}

var transformStyle = getStyleName(transformProp);

var transformNone$1 = 'none';
var displayInline = 'inline';
var displayNone = 'none';
var displayStyle = 'display';

/**
 * Returns true if element is transformed, false if not. In practice the
 * element's display value must be anything else than "none" or "inline" as
 * well as have a valid transform value applied in order to be counted as a
 * transformed element.
 *
 * Borrowed from Mezr (v0.6.1):
 * https://github.com/niklasramo/mezr/blob/0.6.1/mezr.js#L661
 *
 * @param {HTMLElement} element
 * @returns {Boolean}
 */
function isTransformed(element) {
  var transform = getStyle(element, transformStyle);
  if (!transform || transform === transformNone$1) return false;

  var display = getStyle(element, displayStyle);
  if (display === displayInline || display === displayNone) return false;

  return true;
}

/**
 * Returns an absolute positioned element's containing block, which is
 * considered to be the closest ancestor element that the target element's
 * positioning is relative to. Disclaimer: this only works as intended for
 * absolute positioned elements.
 *
 * @param {HTMLElement} element
 * @returns {(Document|Element)}
 */
function getContainingBlock(element) {
  // As long as the containing block is an element, static and not
  // transformed, try to get the element's parent element and fallback to
  // document. https://github.com/niklasramo/mezr/blob/0.6.1/mezr.js#L339
  var doc = document;
  var res = element || doc;
  while (res && res !== doc && getStyle(res, 'position') === 'static' && !isTransformed(res)) {
    res = res.parentElement || doc;
  }
  return res;
}

var offsetA = {};
var offsetB = {};
var offsetDiff = {};

/**
 * Returns the element's document offset, which in practice means the vertical
 * and horizontal distance between the element's northwest corner and the
 * document's northwest corner. Note that this function always returns the same
 * object so be sure to read the data from it instead using it as a reference.
 *
 * @param {(Document|Element|Window)} element
 * @param {Object} [offsetData]
 *   - Optional data object where the offset data will be inserted to. If not
 *     provided a new object will be created for the return data.
 * @returns {Object}
 */
function getOffset(element, offsetData) {
  var offset = offsetData || {};
  var rect;

  // Set up return data.
  offset.left = 0;
  offset.top = 0;

  // Document's offsets are always 0.
  if (element === document) return offset;

  // Add viewport scroll left/top to the respective offsets.
  offset.left = window.pageXOffset || 0;
  offset.top = window.pageYOffset || 0;

  // Window's offsets are the viewport scroll left/top values.
  if (element.self === window.self) return offset;

  // Add element's client rects to the offsets.
  rect = element.getBoundingClientRect();
  offset.left += rect.left;
  offset.top += rect.top;

  // Exclude element's borders from the offset.
  offset.left += getStyleAsFloat(element, 'border-left-width');
  offset.top += getStyleAsFloat(element, 'border-top-width');

  return offset;
}

/**
 * Calculate the offset difference two elements.
 *
 * @param {HTMLElement} elemA
 * @param {HTMLElement} elemB
 * @param {Boolean} [compareContainingBlocks=false]
 *   - When this is set to true the containing blocks of the provided elements
 *     will be used for calculating the difference. Otherwise the provided
 *     elements will be compared directly.
 * @returns {Object}
 */
function getOffsetDiff(elemA, elemB, compareContainingBlocks) {
  offsetDiff.left = 0;
  offsetDiff.top = 0;

  // If elements are same let's return early.
  if (elemA === elemB) return offsetDiff;

  // Compare containing blocks if necessary.
  if (compareContainingBlocks) {
    elemA = getContainingBlock(elemA);
    elemB = getContainingBlock(elemB);

    // If containing blocks are identical, let's return early.
    if (elemA === elemB) return offsetDiff;
  }

  // Finally, let's calculate the offset diff.
  getOffset(elemA, offsetA);
  getOffset(elemB, offsetB);
  offsetDiff.left = offsetB.left - offsetA.left;
  offsetDiff.top = offsetB.top - offsetA.top;

  return offsetDiff;
}

/**
 * Check if overflow style value is scrollable.
 *
 * @param {String} value
 * @returns {Boolean}
 */
function isScrollableOverflow(value) {
  return value === 'auto' || value === 'scroll' || value === 'overlay';
}

/**
 * Check if an element is scrollable.
 *
 * @param {HTMLElement} element
 * @returns {Boolean}
 */
function isScrollable(element) {
  return (
    isScrollableOverflow(getStyle(element, 'overflow')) ||
    isScrollableOverflow(getStyle(element, 'overflow-x')) ||
    isScrollableOverflow(getStyle(element, 'overflow-y'))
  );
}

/**
 * Collect element's ancestors that are potentially scrollable elements. The
 * provided element is also also included in the check, meaning that if it is
 * scrollable it is added to the result array.
 *
 * @param {HTMLElement} element
 * @param {Array} [result]
 * @returns {Array}
 */
function getScrollableAncestors(element, result) {
  result = result || [];

  // Find scroll parents.
  while (element && element !== document) {
    // If element is inside ShadowDOM let's get it's host node from the real
    // DOM and continue looping.
    if (element.getRootNode && element instanceof DocumentFragment) {
      element = element.getRootNode().host;
      continue;
    }

    // If element is scrollable let's add it to the scrollable list.
    if (isScrollable(element)) {
      result.push(element);
    }

    element = element.parentNode;
  }

  // Always add window to the results.
  result.push(window);

  return result;
}

var translateValue = {};
var transformNone = 'none';
var rxMat3d = /^matrix3d/;
var rxMatTx = /([^,]*,){4}/;
var rxMat3dTx = /([^,]*,){12}/;
var rxNextItem = /[^,]*,/;

/**
 * Returns the element's computed translateX and translateY values as a floats.
 * The returned object is always the same object and updated every time this
 * function is called.
 *
 * @param {HTMLElement} element
 * @returns {Object}
 */
function getTranslate(element) {
  translateValue.x = 0;
  translateValue.y = 0;

  var transform = getStyle(element, transformStyle);
  if (!transform || transform === transformNone) {
    return translateValue;
  }

  // Transform style can be in either matrix3d(...) or matrix(...).
  var isMat3d = rxMat3d.test(transform);
  var tX = transform.replace(isMat3d ? rxMat3dTx : rxMatTx, '');
  var tY = tX.replace(rxNextItem, '');

  translateValue.x = parseFloat(tX) || 0;
  translateValue.y = parseFloat(tY) || 0;

  return translateValue;
}

/**
 * Remove class from an element.
 *
 * @param {HTMLElement} element
 * @param {String} className
 */
function removeClass(element, className) {
  if (!className) return;

  if (element.classList) {
    element.classList.remove(className);
  } else {
    if (elementMatches(element, '.' + className)) {
      element.className = (' ' + element.className + ' ')
        .replace(' ' + className + ' ', ' ')
        .trim();
    }
  }
}

var IS_IOS =
  /^(iPad|iPhone|iPod)/.test(window.navigator.platform) ||
  (/^Mac/.test(window.navigator.platform) && window.navigator.maxTouchPoints > 1);
var START_PREDICATE_INACTIVE = 0;
var START_PREDICATE_PENDING = 1;
var START_PREDICATE_RESOLVED = 2;
var SCROLL_LISTENER_OPTIONS = hasPassiveEvents() ? { passive: true } : false;

/**
 * Bind touch interaction to an item.
 *
 * @class
 * @param {Item} item
 */
function ItemDrag(item) {
  var element = item._element;
  var grid = item.getGrid();
  var settings = grid._settings;

  this._item = item;
  this._gridId = grid._id;
  this._isDestroyed = false;
  this._isMigrating = false;

  // Start predicate data.
  this._startPredicate = isFunction(settings.dragStartPredicate)
    ? settings.dragStartPredicate
    : ItemDrag.defaultStartPredicate;
  this._startPredicateState = START_PREDICATE_INACTIVE;
  this._startPredicateResult = undefined;

  // Data for drag sort predicate heuristics.
  this._isSortNeeded = false;
  this._sortTimer = undefined;
  this._blockedSortIndex = null;
  this._sortX1 = 0;
  this._sortX2 = 0;
  this._sortY1 = 0;
  this._sortY2 = 0;

  // Setup item's initial drag data.
  this._reset();

  // Bind the methods that needs binding.
  this._preStartCheck = this._preStartCheck.bind(this);
  this._preEndCheck = this._preEndCheck.bind(this);
  this._onScroll = this._onScroll.bind(this);
  this._prepareStart = this._prepareStart.bind(this);
  this._applyStart = this._applyStart.bind(this);
  this._prepareMove = this._prepareMove.bind(this);
  this._applyMove = this._applyMove.bind(this);
  this._prepareScroll = this._prepareScroll.bind(this);
  this._applyScroll = this._applyScroll.bind(this);
  this._handleSort = this._handleSort.bind(this);
  this._handleSortDelayed = this._handleSortDelayed.bind(this);

  // Get drag handle element.
  this._handle = (settings.dragHandle && element.querySelector(settings.dragHandle)) || element;

  // Init dragger.
  this._dragger = new Dragger(this._handle, settings.dragCssProps);
  this._dragger.on('start', this._preStartCheck);
  this._dragger.on('move', this._preStartCheck);
  this._dragger.on('cancel', this._preEndCheck);
  this._dragger.on('end', this._preEndCheck);
}

/**
 * Public properties
 * *****************
 */

/**
 * @public
 * @static
 * @type {AutoScroller}
 */
ItemDrag.autoScroller = new AutoScroller();

/**
 * Public static methods
 * *********************
 */

/**
 * Default drag start predicate handler that handles anchor elements
 * gracefully. The return value of this function defines if the drag is
 * started, rejected or pending. When true is returned the dragging is started
 * and when false is returned the dragging is rejected. If nothing is returned
 * the predicate will be called again on the next drag movement.
 *
 * @public
 * @static
 * @param {Item} item
 * @param {Object} event
 * @param {Object} [options]
 *   - An optional options object which can be used to pass the predicate
 *     it's options manually. By default the predicate retrieves the options
 *     from the grid's settings.
 * @returns {(Boolean|undefined)}
 */
ItemDrag.defaultStartPredicate = function (item, event, options) {
  var drag = item._drag;

  // Make sure left button is pressed on mouse.
  if (event.isFirst && event.srcEvent.button) {
    return false;
  }

  // If the start event is trusted, non-cancelable and it's default action has
  // not been prevented it is in most cases a sign that the gesture would be
  // cancelled anyways right after it has started (e.g. starting drag while
  // the page is scrolling).
  if (
    !IS_IOS &&
    event.isFirst &&
    event.srcEvent.isTrusted === true &&
    event.srcEvent.defaultPrevented === false &&
    event.srcEvent.cancelable === false
  ) {
    return false;
  }

  // Final event logic. At this stage return value does not matter anymore,
  // the predicate is either resolved or it's not and there's nothing to do
  // about it. Here we just reset data and if the item element is a link
  // we follow it (if there has only been slight movement).
  if (event.isFinal) {
    drag._finishStartPredicate(event);
    return;
  }

  // Setup predicate data from options if not already set.
  var predicate = drag._startPredicateData;
  if (!predicate) {
    var config = options || drag._getGrid()._settings.dragStartPredicate || {};
    drag._startPredicateData = predicate = {
      distance: Math.max(config.distance, 0) || 0,
      delay: Math.max(config.delay, 0) || 0,
    };
  }

  // If delay is defined let's keep track of the latest event and initiate
  // delay if it has not been done yet.
  if (predicate.delay) {
    predicate.event = event;
    if (!predicate.delayTimer) {
      predicate.delayTimer = window.setTimeout(function () {
        predicate.delay = 0;
        if (drag._resolveStartPredicate(predicate.event)) {
          drag._forceResolveStartPredicate(predicate.event);
          drag._resetStartPredicate();
        }
      }, predicate.delay);
    }
  }

  return drag._resolveStartPredicate(event);
};

/**
 * Default drag sort predicate.
 *
 * @public
 * @static
 * @param {Item} item
 * @param {Object} [options]
 * @param {Number} [options.threshold=50]
 * @param {String} [options.action='move']
 * @returns {?Object}
 *   - Returns `null` if no valid index was found. Otherwise returns drag sort
 *     command.
 */
ItemDrag.defaultSortPredicate = (function () {
  var itemRect = {};
  var targetRect = {};
  var returnData = {};
  var gridsArray = [];
  var minThreshold = 1;
  var maxThreshold = 100;

  function getTargetGrid(item, rootGrid, threshold) {
    var target = null;
    var dragSort = rootGrid._settings.dragSort;
    var bestScore = -1;
    var gridScore;
    var grids;
    var grid;
    var container;
    var containerRect;
    var left;
    var top;
    var right;
    var bottom;
    var i;

    // Get potential target grids.
    if (dragSort === true) {
      gridsArray[0] = rootGrid;
      grids = gridsArray;
    } else if (isFunction(dragSort)) {
      grids = dragSort.call(rootGrid, item);
    }

    // Return immediately if there are no grids.
    if (!grids || !Array.isArray(grids) || !grids.length) {
      return target;
    }

    // Loop through the grids and get the best match.
    for (i = 0; i < grids.length; i++) {
      grid = grids[i];

      // Filter out all destroyed grids.
      if (grid._isDestroyed) continue;

      // Compute the grid's client rect an clamp the initial boundaries to
      // viewport dimensions.
      grid._updateBoundingRect();
      left = Math.max(0, grid._left);
      top = Math.max(0, grid._top);
      right = Math.min(window.innerWidth, grid._right);
      bottom = Math.min(window.innerHeight, grid._bottom);

      // The grid might be inside one or more elements that clip it's visibility
      // (e.g overflow scroll/hidden) so we want to find out the visible portion
      // of the grid in the viewport and use that in our calculations.
      container = grid._element.parentNode;
      while (
        container &&
        container !== document &&
        container !== document.documentElement &&
        container !== document.body
      ) {
        if (container.getRootNode && container instanceof DocumentFragment) {
          container = container.getRootNode().host;
          continue;
        }

        if (getStyle(container, 'overflow') !== 'visible') {
          containerRect = container.getBoundingClientRect();
          left = Math.max(left, containerRect.left);
          top = Math.max(top, containerRect.top);
          right = Math.min(right, containerRect.right);
          bottom = Math.min(bottom, containerRect.bottom);
        }

        if (getStyle(container, 'position') === 'fixed') {
          break;
        }

        container = container.parentNode;
      }

      // No need to go further if target rect does not have visible area.
      if (left >= right || top >= bottom) continue;

      // Check how much dragged element overlaps the container element.
      targetRect.left = left;
      targetRect.top = top;
      targetRect.width = right - left;
      targetRect.height = bottom - top;
      gridScore = getIntersectionScore(itemRect, targetRect);

      // Check if this grid is the best match so far.
      if (gridScore > threshold && gridScore > bestScore) {
        bestScore = gridScore;
        target = grid;
      }
    }

    // Always reset grids array.
    gridsArray.length = 0;

    return target;
  }

  return function (item, options) {
    var drag = item._drag;
    var rootGrid = drag._getGrid();

    // Get drag sort predicate settings.
    var sortThreshold = options && typeof options.threshold === 'number' ? options.threshold : 50;
    var sortAction = options && options.action === ACTION_SWAP ? ACTION_SWAP : ACTION_MOVE;
    var migrateAction =
      options && options.migrateAction === ACTION_SWAP ? ACTION_SWAP : ACTION_MOVE;

    // Sort threshold must be a positive number capped to a max value of 100. If
    // that's not the case this function will not work correctly. So let's clamp
    // the threshold just in case.
    sortThreshold = Math.min(Math.max(sortThreshold, minThreshold), maxThreshold);

    // Populate item rect data.
    itemRect.width = item._width;
    itemRect.height = item._height;
    itemRect.left = drag._clientX;
    itemRect.top = drag._clientY;

    // Calculate the target grid.
    var grid = getTargetGrid(item, rootGrid, sortThreshold);

    // Return early if we found no grid container element that overlaps the
    // dragged item enough.
    if (!grid) return null;

    var isMigration = item.getGrid() !== grid;
    var gridOffsetLeft = 0;
    var gridOffsetTop = 0;
    var matchScore = 0;
    var matchIndex = -1;
    var hasValidTargets = false;
    var target;
    var score;
    var i;

    // If item is moved within it's originating grid adjust item's left and
    // top props. Otherwise if item is moved to/within another grid get the
    // container element's offset (from the element's content edge).
    if (grid === rootGrid) {
      itemRect.left = drag._gridX + item._marginLeft;
      itemRect.top = drag._gridY + item._marginTop;
    } else {
      grid._updateBorders(1, 0, 1, 0);
      gridOffsetLeft = grid._left + grid._borderLeft;
      gridOffsetTop = grid._top + grid._borderTop;
    }

    // Loop through the target grid items and try to find the best match.
    for (i = 0; i < grid._items.length; i++) {
      target = grid._items[i];

      // If the target item is not active or the target item is the dragged
      // item let's skip to the next item.
      if (!target._isActive || target === item) {
        continue;
      }

      // Mark the grid as having valid target items.
      hasValidTargets = true;

      // Calculate the target's overlap score with the dragged item.
      targetRect.width = target._width;
      targetRect.height = target._height;
      targetRect.left = target._left + target._marginLeft + gridOffsetLeft;
      targetRect.top = target._top + target._marginTop + gridOffsetTop;
      score = getIntersectionScore(itemRect, targetRect);

      // Update best match index and score if the target's overlap score with
      // the dragged item is higher than the current best match score.
      if (score > matchScore) {
        matchIndex = i;
        matchScore = score;
      }
    }

    // If there is no valid match and the dragged item is being moved into
    // another grid we need to do some guess work here. If there simply are no
    // valid targets (which means that the dragged item will be the only active
    // item in the new grid) we can just add it as the first item. If we have
    // valid items in the new grid and the dragged item is overlapping one or
    // more of the items in the new grid let's make an exception with the
    // threshold and just pick the item which the dragged item is overlapping
    // most. However, if the dragged item is not overlapping any of the valid
    // items in the new grid let's position it as the last item in the grid.
    if (isMigration && matchScore < sortThreshold) {
      matchIndex = hasValidTargets ? matchIndex : 0;
      matchScore = sortThreshold;
    }

    // Check if the best match overlaps enough to justify a placement switch.
    if (matchScore >= sortThreshold) {
      returnData.grid = grid;
      returnData.index = matchIndex;
      returnData.action = isMigration ? migrateAction : sortAction;
      return returnData;
    }

    return null;
  };
})();

/**
 * Public prototype methods
 * ************************
 */

/**
 * Abort dragging and reset drag data.
 *
 * @public
 */
ItemDrag.prototype.stop = function () {
  if (!this._isActive) return;

  // If the item is being dropped into another grid, finish it up and return
  // immediately.
  if (this._isMigrating) {
    this._finishMigration();
    return;
  }

  var item = this._item;
  var itemId = item._id;

  // Stop auto-scroll.
  ItemDrag.autoScroller.removeItem(item);

  // Cancel queued ticks.
  cancelDragStartTick(itemId);
  cancelDragMoveTick(itemId);
  cancelDragScrollTick(itemId);

  // Cancel sort procedure.
  this._cancelSort();

  if (this._isStarted) {
    // Remove scroll listeners.
    this._unbindScrollListeners();

    var element = item._element;
    var grid = this._getGrid();
    var draggingClass = grid._settings.itemDraggingClass;

    // Append item element to the container if it's not it's child. Also make
    // sure the translate values are adjusted to account for the DOM shift.
    if (element.parentNode !== grid._element) {
      grid._element.appendChild(element);
      item._setTranslate(this._gridX, this._gridY);

      // We need to do forced reflow to make sure the dragging class is removed
      // gracefully.
      // eslint-disable-next-line
      if (draggingClass) element.clientWidth;
    }

    // Remove dragging class.
    removeClass(element, draggingClass);
  }

  // Reset drag data.
  this._reset();
};

/**
 * Manually trigger drag sort. This is only needed for special edge cases where
 * e.g. you have disabled sort and want to trigger a sort right after enabling
 * it (and don't want to wait for the next move/scroll event).
 *
 * @private
 * @param {Boolean} [force=false]
 */
ItemDrag.prototype.sort = function (force) {
  var item = this._item;
  if (this._isActive && item._isActive && this._dragMoveEvent) {
    if (force === true) {
      this._handleSort();
    } else {
      addDragSortTick(item._id, this._handleSort);
    }
  }
};

/**
 * Destroy instance.
 *
 * @public
 */
ItemDrag.prototype.destroy = function () {
  if (this._isDestroyed) return;
  this.stop();
  this._dragger.destroy();
  ItemDrag.autoScroller.removeItem(this._item);
  this._isDestroyed = true;
};

/**
 * Private prototype methods
 * *************************
 */

/**
 * Get Grid instance.
 *
 * @private
 * @returns {?Grid}
 */
ItemDrag.prototype._getGrid = function () {
  return GRID_INSTANCES[this._gridId] || null;
};

/**
 * Setup/reset drag data.
 *
 * @private
 */
ItemDrag.prototype._reset = function () {
  this._isActive = false;
  this._isStarted = false;

  // The dragged item's container element.
  this._container = null;

  // The dragged item's containing block.
  this._containingBlock = null;

  // Drag/scroll event data.
  this._dragStartEvent = null;
  this._dragMoveEvent = null;
  this._dragPrevMoveEvent = null;
  this._scrollEvent = null;

  // All the elements which need to be listened for scroll events during
  // dragging.
  this._scrollers = [];

  // The current translateX/translateY position.
  this._left = 0;
  this._top = 0;

  // Dragged element's current position within the grid.
  this._gridX = 0;
  this._gridY = 0;

  // Dragged element's current offset from window's northwest corner. Does
  // not account for element's margins.
  this._clientX = 0;
  this._clientY = 0;

  // Keep track of the clientX/Y diff for scrolling.
  this._scrollDiffX = 0;
  this._scrollDiffY = 0;

  // Keep track of the clientX/Y diff for moving.
  this._moveDiffX = 0;
  this._moveDiffY = 0;

  // Offset difference between the dragged element's temporary drag
  // container and it's original container.
  this._containerDiffX = 0;
  this._containerDiffY = 0;
};

/**
 * Bind drag scroll handlers to all scrollable ancestor elements of the
 * dragged element and the drag container element.
 *
 * @private
 */
ItemDrag.prototype._bindScrollListeners = function () {
  var gridContainer = this._getGrid()._element;
  var dragContainer = this._container;
  var scrollers = this._scrollers;
  var gridScrollers;
  var i;

  // Get dragged element's scrolling parents.
  scrollers.length = 0;
  getScrollableAncestors(this._item._element.parentNode, scrollers);

  // If drag container is defined and it's not the same element as grid
  // container then we need to add the grid container and it's scroll parents
  // to the elements which are going to be listener for scroll events.
  if (dragContainer !== gridContainer) {
    gridScrollers = [];
    getScrollableAncestors(gridContainer, gridScrollers);
    for (i = 0; i < gridScrollers.length; i++) {
      if (scrollers.indexOf(gridScrollers[i]) < 0) {
        scrollers.push(gridScrollers[i]);
      }
    }
  }

  // Bind scroll listeners.
  for (i = 0; i < scrollers.length; i++) {
    scrollers[i].addEventListener('scroll', this._onScroll, SCROLL_LISTENER_OPTIONS);
  }
};

/**
 * Unbind currently bound drag scroll handlers from all scrollable ancestor
 * elements of the dragged element and the drag container element.
 *
 * @private
 */
ItemDrag.prototype._unbindScrollListeners = function () {
  var scrollers = this._scrollers;
  var i;

  for (i = 0; i < scrollers.length; i++) {
    scrollers[i].removeEventListener('scroll', this._onScroll, SCROLL_LISTENER_OPTIONS);
  }

  scrollers.length = 0;
};

/**
 * Unbind currently bound drag scroll handlers from all scrollable ancestor
 * elements of the dragged element and the drag container element.
 *
 * @private
 * @param {Object} event
 * @returns {Boolean}
 */
ItemDrag.prototype._resolveStartPredicate = function (event) {
  var predicate = this._startPredicateData;
  if (event.distance < predicate.distance || predicate.delay) return;
  this._resetStartPredicate();
  return true;
};

/**
 * Forcefully resolve drag start predicate.
 *
 * @private
 * @param {Object} event
 */
ItemDrag.prototype._forceResolveStartPredicate = function (event) {
  if (!this._isDestroyed && this._startPredicateState === START_PREDICATE_PENDING) {
    this._startPredicateState = START_PREDICATE_RESOLVED;
    this._onStart(event);
  }
};

/**
 * Finalize start predicate.
 *
 * @private
 * @param {Object} event
 */
ItemDrag.prototype._finishStartPredicate = function (event) {
  var element = this._item._element;

  // Check if this is a click (very subjective heuristics).
  var isClick = Math.abs(event.deltaX) < 2 && Math.abs(event.deltaY) < 2 && event.deltaTime < 200;

  // Reset predicate.
  this._resetStartPredicate();

  // If the gesture can be interpreted as click let's try to open the element's
  // href url (if it is an anchor element).
  if (isClick) openAnchorHref(element);
};

/**
 * Reset drag sort heuristics.
 *
 * @private
 * @param {Number} x
 * @param {Number} y
 */
ItemDrag.prototype._resetHeuristics = function (x, y) {
  this._blockedSortIndex = null;
  this._sortX1 = this._sortX2 = x;
  this._sortY1 = this._sortY2 = y;
};

/**
 * Run heuristics and return true if overlap check can be performed, and false
 * if it can not.
 *
 * @private
 * @param {Number} x
 * @param {Number} y
 * @returns {Boolean}
 */
ItemDrag.prototype._checkHeuristics = function (x, y) {
  var settings = this._getGrid()._settings.dragSortHeuristics;
  var minDist = settings.minDragDistance;

  // Skip heuristics if not needed.
  if (minDist <= 0) {
    this._blockedSortIndex = null;
    return true;
  }

  var diffX = x - this._sortX2;
  var diffY = y - this._sortY2;

  // If we can't do proper bounce back check make sure that the blocked index
  // is not set.
  var canCheckBounceBack = minDist > 3 && settings.minBounceBackAngle > 0;
  if (!canCheckBounceBack) {
    this._blockedSortIndex = null;
  }

  if (Math.abs(diffX) > minDist || Math.abs(diffY) > minDist) {
    // Reset blocked index if angle changed enough. This check requires a
    // minimum value of 3 for minDragDistance to function properly.
    if (canCheckBounceBack) {
      var angle = Math.atan2(diffX, diffY);
      var prevAngle = Math.atan2(this._sortX2 - this._sortX1, this._sortY2 - this._sortY1);
      var deltaAngle = Math.atan2(Math.sin(angle - prevAngle), Math.cos(angle - prevAngle));
      if (Math.abs(deltaAngle) > settings.minBounceBackAngle) {
        this._blockedSortIndex = null;
      }
    }

    // Update points.
    this._sortX1 = this._sortX2;
    this._sortY1 = this._sortY2;
    this._sortX2 = x;
    this._sortY2 = y;

    return true;
  }

  return false;
};

/**
 * Reset for default drag start predicate function.
 *
 * @private
 */
ItemDrag.prototype._resetStartPredicate = function () {
  var predicate = this._startPredicateData;
  if (predicate) {
    if (predicate.delayTimer) {
      predicate.delayTimer = window.clearTimeout(predicate.delayTimer);
    }
    this._startPredicateData = null;
  }
};

/**
 * Handle the sorting procedure. Manage drag sort heuristics/interval and
 * check overlap when necessary.
 *
 * @private
 */
ItemDrag.prototype._handleSort = function () {
  if (!this._isActive) return;

  var settings = this._getGrid()._settings;

  // No sorting when drag sort is disabled. Also, account for the scenario where
  // dragSort is temporarily disabled during drag procedure so we need to reset
  // sort timer heuristics state too.
  if (
    !settings.dragSort ||
    (!settings.dragAutoScroll.sortDuringScroll && ItemDrag.autoScroller.isItemScrolling(this._item))
  ) {
    this._sortX1 = this._sortX2 = this._gridX;
    this._sortY1 = this._sortY2 = this._gridY;
    // We set this to true intentionally so that overlap check would be
    // triggered as soon as possible after sort becomes enabled again.
    this._isSortNeeded = true;
    if (this._sortTimer !== undefined) {
      this._sortTimer = window.clearTimeout(this._sortTimer);
    }
    return;
  }

  // If sorting is enabled we always need to run the heuristics check to keep
  // the tracked coordinates updated. We also allow an exception when the sort
  // timer is finished because the heuristics are intended to prevent overlap
  // checks based on the dragged element's immediate movement and a delayed
  // overlap check is valid if it comes through, because it was valid when it
  // was invoked.
  var shouldSort = this._checkHeuristics(this._gridX, this._gridY);
  if (!this._isSortNeeded && !shouldSort) return;

  var sortInterval = settings.dragSortHeuristics.sortInterval;
  if (sortInterval <= 0 || this._isSortNeeded) {
    this._isSortNeeded = false;
    if (this._sortTimer !== undefined) {
      this._sortTimer = window.clearTimeout(this._sortTimer);
    }
    this._checkOverlap();
  } else if (this._sortTimer === undefined) {
    this._sortTimer = window.setTimeout(this._handleSortDelayed, sortInterval);
  }
};

/**
 * Delayed sort handler.
 *
 * @private
 */
ItemDrag.prototype._handleSortDelayed = function () {
  this._isSortNeeded = true;
  this._sortTimer = undefined;
  addDragSortTick(this._item._id, this._handleSort);
};

/**
 * Cancel and reset sort procedure.
 *
 * @private
 */
ItemDrag.prototype._cancelSort = function () {
  this._isSortNeeded = false;
  if (this._sortTimer !== undefined) {
    this._sortTimer = window.clearTimeout(this._sortTimer);
  }
  cancelDragSortTick(this._item._id);
};

/**
 * Handle the ending of the drag procedure for sorting.
 *
 * @private
 */
ItemDrag.prototype._finishSort = function () {
  var isSortEnabled = this._getGrid()._settings.dragSort;
  var needsFinalCheck = isSortEnabled && (this._isSortNeeded || this._sortTimer !== undefined);
  this._cancelSort();
  if (needsFinalCheck) this._checkOverlap();
};

/**
 * Check (during drag) if an item is overlapping other items and based on
 * the configuration layout the items.
 *
 * @private
 */
ItemDrag.prototype._checkOverlap = function () {
  if (!this._isActive) return;

  var item = this._item;
  var settings = this._getGrid()._settings;
  var result;
  var currentGrid;
  var currentIndex;
  var targetGrid;
  var targetIndex;
  var targetItem;
  var sortAction;
  var isMigration;

  // Get overlap check result.
  if (isFunction(settings.dragSortPredicate)) {
    result = settings.dragSortPredicate(item, this._dragMoveEvent);
  } else {
    result = ItemDrag.defaultSortPredicate(item, settings.dragSortPredicate);
  }

  // Let's make sure the result object has a valid index before going further.
  if (!result || typeof result.index !== 'number') return;

  sortAction = result.action === ACTION_SWAP ? ACTION_SWAP : ACTION_MOVE;
  currentGrid = item.getGrid();
  targetGrid = result.grid || currentGrid;
  isMigration = currentGrid !== targetGrid;
  currentIndex = currentGrid._items.indexOf(item);
  targetIndex = normalizeArrayIndex(
    targetGrid._items,
    result.index,
    isMigration && sortAction === ACTION_MOVE ? 1 : 0
  );

  // Prevent position bounce.
  if (!isMigration && targetIndex === this._blockedSortIndex) {
    return;
  }

  // If the item was moved within it's current grid.
  if (!isMigration) {
    // Make sure the target index is not the current index.
    if (currentIndex !== targetIndex) {
      this._blockedSortIndex = currentIndex;

      // Do the sort.
      (sortAction === ACTION_SWAP ? arraySwap : arrayMove)(
        currentGrid._items,
        currentIndex,
        targetIndex
      );

      // Emit move event.
      if (currentGrid._hasListeners(EVENT_MOVE)) {
        currentGrid._emit(EVENT_MOVE, {
          item: item,
          fromIndex: currentIndex,
          toIndex: targetIndex,
          action: sortAction,
        });
      }

      // Layout the grid.
      currentGrid.layout();
    }
  }

  // If the item was moved to another grid.
  else {
    this._blockedSortIndex = null;

    // Let's fetch the target item when it's still in it's original index.
    targetItem = targetGrid._items[targetIndex];

    // Emit beforeSend event.
    if (currentGrid._hasListeners(EVENT_BEFORE_SEND)) {
      currentGrid._emit(EVENT_BEFORE_SEND, {
        item: item,
        fromGrid: currentGrid,
        fromIndex: currentIndex,
        toGrid: targetGrid,
        toIndex: targetIndex,
      });
    }

    // Emit beforeReceive event.
    if (targetGrid._hasListeners(EVENT_BEFORE_RECEIVE)) {
      targetGrid._emit(EVENT_BEFORE_RECEIVE, {
        item: item,
        fromGrid: currentGrid,
        fromIndex: currentIndex,
        toGrid: targetGrid,
        toIndex: targetIndex,
      });
    }

    // Update item's grid id reference.
    item._gridId = targetGrid._id;

    // Update drag instance's migrating indicator.
    this._isMigrating = item._gridId !== this._gridId;

    // Move item instance from current grid to target grid.
    currentGrid._items.splice(currentIndex, 1);
    arrayInsert(targetGrid._items, item, targetIndex);

    // Reset sort data.
    item._sortData = null;

    // Emit send event.
    if (currentGrid._hasListeners(EVENT_SEND)) {
      currentGrid._emit(EVENT_SEND, {
        item: item,
        fromGrid: currentGrid,
        fromIndex: currentIndex,
        toGrid: targetGrid,
        toIndex: targetIndex,
      });
    }

    // Emit receive event.
    if (targetGrid._hasListeners(EVENT_RECEIVE)) {
      targetGrid._emit(EVENT_RECEIVE, {
        item: item,
        fromGrid: currentGrid,
        fromIndex: currentIndex,
        toGrid: targetGrid,
        toIndex: targetIndex,
      });
    }

    // If the sort action is "swap" let's respect it and send the target item
    // (if it exists) from the target grid to the originating grid. This process
    // is done on purpose after the dragged item placed within the target grid
    // so that we can keep this implementation as simple as possible utilizing
    // the existing API.
    if (sortAction === ACTION_SWAP && targetItem && targetItem.isActive()) {
      // Sanity check to make sure that the target item is still part of the
      // target grid. It could have been manipulated in the event handlers.
      if (targetGrid._items.indexOf(targetItem) > -1) {
        targetGrid.send(targetItem, currentGrid, currentIndex, {
          appendTo: this._container || document.body,
          layoutSender: false,
          layoutReceiver: false,
        });
      }
    }

    // Layout both grids.
    currentGrid.layout();
    targetGrid.layout();
  }
};

/**
 * If item is dragged into another grid, finish the migration process
 * gracefully.
 *
 * @private
 */
ItemDrag.prototype._finishMigration = function () {
  var item = this._item;
  var release = item._dragRelease;
  var element = item._element;
  var isActive = item._isActive;
  var targetGrid = item.getGrid();
  var targetGridElement = targetGrid._element;
  var targetSettings = targetGrid._settings;
  var targetContainer = targetSettings.dragContainer || targetGridElement;
  var currentSettings = this._getGrid()._settings;
  var currentContainer = element.parentNode;
  var currentVisClass = isActive
    ? currentSettings.itemVisibleClass
    : currentSettings.itemHiddenClass;
  var nextVisClass = isActive ? targetSettings.itemVisibleClass : targetSettings.itemHiddenClass;
  var translate;
  var offsetDiff;

  // Destroy current drag. Note that we need to set the migrating flag to
  // false first, because otherwise we create an infinite loop between this
  // and the drag.stop() method.
  this._isMigrating = false;
  this.destroy();

  // Update item class.
  if (currentSettings.itemClass !== targetSettings.itemClass) {
    removeClass(element, currentSettings.itemClass);
    addClass(element, targetSettings.itemClass);
  }

  // Update visibility class.
  if (currentVisClass !== nextVisClass) {
    removeClass(element, currentVisClass);
    addClass(element, nextVisClass);
  }

  // Move the item inside the target container if it's different than the
  // current container.
  if (targetContainer !== currentContainer) {
    targetContainer.appendChild(element);
    offsetDiff = getOffsetDiff(currentContainer, targetContainer, true);
    translate = getTranslate(element);
    translate.x -= offsetDiff.left;
    translate.y -= offsetDiff.top;
  }

  // Update item's cached dimensions.
  item._refreshDimensions();

  // Calculate the offset difference between target's drag container (if any)
  // and actual grid container element. We save it later for the release
  // process.
  offsetDiff = getOffsetDiff(targetContainer, targetGridElement, true);
  release._containerDiffX = offsetDiff.left;
  release._containerDiffY = offsetDiff.top;

  // Recreate item's drag handler.
  item._drag = targetSettings.dragEnabled ? new ItemDrag(item) : null;

  // Adjust the position of the item element if it was moved from a container
  // to another.
  if (targetContainer !== currentContainer) {
    item._setTranslate(translate.x, translate.y);
  }

  // Update child element's styles to reflect the current visibility state.
  item._visibility.setStyles(isActive ? targetSettings.visibleStyles : targetSettings.hiddenStyles);

  // Start the release.
  release.start();
};

/**
 * Drag pre-start handler.
 *
 * @private
 * @param {Object} event
 */
ItemDrag.prototype._preStartCheck = function (event) {
  // Let's activate drag start predicate state.
  if (this._startPredicateState === START_PREDICATE_INACTIVE) {
    this._startPredicateState = START_PREDICATE_PENDING;
  }

  // If predicate is pending try to resolve it.
  if (this._startPredicateState === START_PREDICATE_PENDING) {
    this._startPredicateResult = this._startPredicate(this._item, event);
    if (this._startPredicateResult === true) {
      this._startPredicateState = START_PREDICATE_RESOLVED;
      this._onStart(event);
    } else if (this._startPredicateResult === false) {
      this._resetStartPredicate(event);
      this._dragger._reset();
      this._startPredicateState = START_PREDICATE_INACTIVE;
    }
  }

  // Otherwise if predicate is resolved and drag is active, move the item.
  else if (this._startPredicateState === START_PREDICATE_RESOLVED && this._isActive) {
    this._onMove(event);
  }
};

/**
 * Drag pre-end handler.
 *
 * @private
 * @param {Object} event
 */
ItemDrag.prototype._preEndCheck = function (event) {
  var isResolved = this._startPredicateState === START_PREDICATE_RESOLVED;

  // Do final predicate check to allow user to unbind stuff for the current
  // drag procedure within the predicate callback. The return value of this
  // check will have no effect to the state of the predicate.
  this._startPredicate(this._item, event);

  this._startPredicateState = START_PREDICATE_INACTIVE;

  if (!isResolved || !this._isActive) return;

  if (this._isStarted) {
    this._onEnd(event);
  } else {
    this.stop();
  }
};

/**
 * Drag start handler.
 *
 * @private
 * @param {Object} event
 */
ItemDrag.prototype._onStart = function (event) {
  var item = this._item;
  if (!item._isActive) return;

  this._isActive = true;
  this._dragStartEvent = event;
  ItemDrag.autoScroller.addItem(item);

  addDragStartTick(item._id, this._prepareStart, this._applyStart);
};

/**
 * Prepare item to be dragged.
 *
 * @private
 *  ItemDrag.prototype
 */
ItemDrag.prototype._prepareStart = function () {
  if (!this._isActive) return;

  var item = this._item;
  if (!item._isActive) return;

  var element = item._element;
  var grid = this._getGrid();
  var settings = grid._settings;
  var gridContainer = grid._element;
  var dragContainer = settings.dragContainer || gridContainer;
  var containingBlock = getContainingBlock(dragContainer);
  var translate = getTranslate(element);
  var elementRect = element.getBoundingClientRect();
  var hasDragContainer = dragContainer !== gridContainer;

  this._container = dragContainer;
  this._containingBlock = containingBlock;
  this._clientX = elementRect.left;
  this._clientY = elementRect.top;
  this._left = this._gridX = translate.x;
  this._top = this._gridY = translate.y;
  this._scrollDiffX = this._scrollDiffY = 0;
  this._moveDiffX = this._moveDiffY = 0;

  this._resetHeuristics(this._gridX, this._gridY);

  // If a specific drag container is set and it is different from the
  // grid's container element we store the offset between containers.
  if (hasDragContainer) {
    var offsetDiff = getOffsetDiff(containingBlock, gridContainer);
    this._containerDiffX = offsetDiff.left;
    this._containerDiffY = offsetDiff.top;
  }
};

/**
 * Start drag for the item.
 *
 * @private
 */
ItemDrag.prototype._applyStart = function () {
  if (!this._isActive) return;

  var item = this._item;
  if (!item._isActive) return;

  var grid = this._getGrid();
  var element = item._element;
  var release = item._dragRelease;
  var migrate = item._migrate;
  var hasDragContainer = this._container !== grid._element;

  if (item.isPositioning()) {
    item._layout.stop(true, this._left, this._top);
  }

  if (migrate._isActive) {
    this._left -= migrate._containerDiffX;
    this._top -= migrate._containerDiffY;
    this._gridX -= migrate._containerDiffX;
    this._gridY -= migrate._containerDiffY;
    migrate.stop(true, this._left, this._top);
  }

  if (item.isReleasing()) {
    release._reset();
  }

  if (grid._settings.dragPlaceholder.enabled) {
    item._dragPlaceholder.create();
  }

  this._isStarted = true;

  grid._emit(EVENT_DRAG_INIT, item, this._dragStartEvent);

  if (hasDragContainer) {
    // If the dragged element is a child of the drag container all we need to
    // do is setup the relative drag position data.
    if (element.parentNode === this._container) {
      this._gridX -= this._containerDiffX;
      this._gridY -= this._containerDiffY;
    }
    // Otherwise we need to append the element inside the correct container,
    // setup the actual drag position data and adjust the element's translate
    // values to account for the DOM position shift.
    else {
      this._left += this._containerDiffX;
      this._top += this._containerDiffY;
      this._container.appendChild(element);
      item._setTranslate(this._left, this._top);
    }
  }

  addClass(element, grid._settings.itemDraggingClass);
  this._bindScrollListeners();
  grid._emit(EVENT_DRAG_START, item, this._dragStartEvent);
};

/**
 * Drag move handler.
 *
 * @private
 * @param {Object} event
 */
ItemDrag.prototype._onMove = function (event) {
  var item = this._item;

  if (!item._isActive) {
    this.stop();
    return;
  }

  this._dragMoveEvent = event;
  addDragMoveTick(item._id, this._prepareMove, this._applyMove);
  addDragSortTick(item._id, this._handleSort);
};

/**
 * Prepare dragged item for moving.
 *
 * @private
 */
ItemDrag.prototype._prepareMove = function () {
  if (!this._isActive) return;

  var item = this._item;
  if (!item._isActive) return;

  var settings = this._getGrid()._settings;
  var axis = settings.dragAxis;
  var nextEvent = this._dragMoveEvent;
  var prevEvent = this._dragPrevMoveEvent || this._dragStartEvent || nextEvent;

  // Update horizontal position data.
  if (axis !== 'y') {
    var moveDiffX = nextEvent.clientX - prevEvent.clientX;
    this._left = this._left - this._moveDiffX + moveDiffX;
    this._gridX = this._gridX - this._moveDiffX + moveDiffX;
    this._clientX = this._clientX - this._moveDiffX + moveDiffX;
    this._moveDiffX = moveDiffX;
  }

  // Update vertical position data.
  if (axis !== 'x') {
    var moveDiffY = nextEvent.clientY - prevEvent.clientY;
    this._top = this._top - this._moveDiffY + moveDiffY;
    this._gridY = this._gridY - this._moveDiffY + moveDiffY;
    this._clientY = this._clientY - this._moveDiffY + moveDiffY;
    this._moveDiffY = moveDiffY;
  }

  this._dragPrevMoveEvent = nextEvent;
};

/**
 * Apply movement to dragged item.
 *
 * @private
 */
ItemDrag.prototype._applyMove = function () {
  if (!this._isActive) return;

  var item = this._item;
  if (!item._isActive) return;

  this._moveDiffX = this._moveDiffY = 0;
  item._setTranslate(this._left, this._top);
  this._getGrid()._emit(EVENT_DRAG_MOVE, item, this._dragMoveEvent);
  ItemDrag.autoScroller.updateItem(item);
};

/**
 * Drag scroll handler.
 *
 * @private
 * @param {Object} event
 */
ItemDrag.prototype._onScroll = function (event) {
  var item = this._item;

  if (!item._isActive) {
    this.stop();
    return;
  }

  this._scrollEvent = event;
  addDragScrollTick(item._id, this._prepareScroll, this._applyScroll);
  addDragSortTick(item._id, this._handleSort);
};

/**
 * Prepare dragged item for scrolling.
 *
 * @private
 */
ItemDrag.prototype._prepareScroll = function () {
  if (!this._isActive) return;

  // If item is not active do nothing.
  var item = this._item;
  if (!item._isActive) return;

  var element = item._element;
  var grid = this._getGrid();
  var gridContainer = grid._element;
  var rect = element.getBoundingClientRect();

  // Update container diff.
  if (this._container !== gridContainer) {
    var offsetDiff = getOffsetDiff(this._containingBlock, gridContainer);
    this._containerDiffX = offsetDiff.left;
    this._containerDiffY = offsetDiff.top;
  }

  // Update horizontal position data.
  var scrollDiffX = this._clientX - this._moveDiffX - rect.left;
  this._left = this._left - this._scrollDiffX + scrollDiffX;
  this._scrollDiffX = scrollDiffX;

  // Update vertical position data.
  var scrollDiffY = this._clientY - this._moveDiffY - rect.top;
  this._top = this._top - this._scrollDiffY + scrollDiffY;
  this._scrollDiffY = scrollDiffY;

  // Update grid position.
  this._gridX = this._left - this._containerDiffX;
  this._gridY = this._top - this._containerDiffY;
};

/**
 * Apply scroll to dragged item.
 *
 * @private
 */
ItemDrag.prototype._applyScroll = function () {
  if (!this._isActive) return;

  var item = this._item;
  if (!item._isActive) return;

  this._scrollDiffX = this._scrollDiffY = 0;
  item._setTranslate(this._left, this._top);
  this._getGrid()._emit(EVENT_DRAG_SCROLL, item, this._scrollEvent);
};

/**
 * Drag end handler.
 *
 * @private
 * @param {Object} event
 */
ItemDrag.prototype._onEnd = function (event) {
  var item = this._item;
  var element = item._element;
  var grid = this._getGrid();
  var settings = grid._settings;
  var release = item._dragRelease;

  // If item is not active, reset drag.
  if (!item._isActive) {
    this.stop();
    return;
  }

  // Cancel queued ticks.
  cancelDragStartTick(item._id);
  cancelDragMoveTick(item._id);
  cancelDragScrollTick(item._id);

  // Finish sort procedure (does final overlap check if needed).
  this._finishSort();

  // Remove scroll listeners.
  this._unbindScrollListeners();

  // Setup release data.
  release._containerDiffX = this._containerDiffX;
  release._containerDiffY = this._containerDiffY;

  // Reset drag data.
  this._reset();

  // Remove drag class name from element.
  removeClass(element, settings.itemDraggingClass);

  // Stop auto-scroll.
  ItemDrag.autoScroller.removeItem(item);

  // Emit dragEnd event.
  grid._emit(EVENT_DRAG_END, item, event);

  // Finish up the migration process or start the release process.
  this._isMigrating ? this._finishMigration() : release.start();
};

/**
 * Private helpers
 * ***************
 */

/**
 * Check if an element is an anchor element and open the href url if possible.
 *
 * @param {HTMLElement} element
 */
function openAnchorHref(element) {
  // Make sure the element is anchor element.
  if (element.tagName.toLowerCase() !== 'a') return;

  // Get href and make sure it exists.
  var href = element.getAttribute('href');
  if (!href) return;

  // Finally let's navigate to the link href.
  var target = element.getAttribute('target');
  if (target && target !== '_self') {
    window.open(href, target);
  } else {
    window.location.href = href;
  }
}

/**
 * Get current values of the provided styles definition object or array.
 *
 * @param {HTMLElement} element
 * @param {(Object|Array} styles
 * @return {Object}
 */
function getCurrentStyles(element, styles) {
  var result = {};
  var prop, i;

  if (Array.isArray(styles)) {
    for (i = 0; i < styles.length; i++) {
      prop = styles[i];
      result[prop] = getStyle(element, getStyleName(prop));
    }
  } else {
    for (prop in styles) {
      result[prop] = getStyle(element, getStyleName(prop));
    }
  }

  return result;
}

var unprefixRegEx = /^(webkit|moz|ms|o|Webkit|Moz|MS|O)(?=[A-Z])/;
var cache = {};

/**
 * Remove any potential vendor prefixes from a property name.
 *
 * @param {String} prop
 * @returns {String}
 */
function getUnprefixedPropName(prop) {
  var result = cache[prop];
  if (result) return result;

  result = prop.replace(unprefixRegEx, '');

  if (result !== prop) {
    result = result[0].toLowerCase() + result.slice(1);
  }

  cache[prop] = result;

  return result;
}

var nativeCode = '[native code]';

/**
 * Check if a value (e.g. a method or constructor) is native code. Good for
 * detecting when a polyfill is used and when not.
 *
 * @param {*} feat
 * @returns {Boolean}
 */
function isNative(feat) {
  var S = window.Symbol;
  return !!(
    feat &&
    isFunction(S) &&
    isFunction(S.toString) &&
    S(feat).toString().indexOf(nativeCode) > -1
  );
}

/**
 * Set inline styles to an element.
 *
 * @param {HTMLElement} element
 * @param {Object} styles
 */
function setStyles(element, styles) {
  for (var prop in styles) {
    element.style[prop] = styles[prop];
  }
}

var HAS_WEB_ANIMATIONS = !!(Element && isFunction(Element.prototype.animate));
var HAS_NATIVE_WEB_ANIMATIONS = !!(Element && isNative(Element.prototype.animate));

/**
 * Item animation handler powered by Web Animations API.
 *
 * @class
 * @param {HTMLElement} element
 */
function Animator(element) {
  this._element = element;
  this._animation = null;
  this._duration = 0;
  this._easing = '';
  this._callback = null;
  this._props = [];
  this._values = [];
  this._isDestroyed = false;
  this._onFinish = this._onFinish.bind(this);
}

/**
 * Public prototype methods
 * ************************
 */

/**
 * Start instance's animation. Automatically stops current animation if it is
 * running.
 *
 * @public
 * @param {Object} propsFrom
 * @param {Object} propsTo
 * @param {Object} [options]
 * @param {Number} [options.duration=300]
 * @param {String} [options.easing='ease']
 * @param {Function} [options.onFinish]
 */
Animator.prototype.start = function (propsFrom, propsTo, options) {
  if (this._isDestroyed) return;

  var element = this._element;
  var opts = options || {};

  // If we don't have web animations available let's not animate.
  if (!HAS_WEB_ANIMATIONS) {
    setStyles(element, propsTo);
    this._callback = isFunction(opts.onFinish) ? opts.onFinish : null;
    this._onFinish();
    return;
  }

  var animation = this._animation;
  var currentProps = this._props;
  var currentValues = this._values;
  var duration = opts.duration || 300;
  var easing = opts.easing || 'ease';
  var cancelAnimation = false;
  var propName, propCount, propIndex;

  // If we have an existing animation running, let's check if it needs to be
  // cancelled or if it can continue running.
  if (animation) {
    propCount = 0;

    // Cancel animation if duration or easing has changed.
    if (duration !== this._duration || easing !== this._easing) {
      cancelAnimation = true;
    }

    // Check if the requested animation target props and values match with the
    // current props and values.
    if (!cancelAnimation) {
      for (propName in propsTo) {
        ++propCount;
        propIndex = currentProps.indexOf(propName);
        if (propIndex === -1 || propsTo[propName] !== currentValues[propIndex]) {
          cancelAnimation = true;
          break;
        }
      }

      // Check if the target props count matches current props count. This is
      // needed for the edge case scenario where target props contain the same
      // styles as current props, but the current props have some additional
      // props.
      if (propCount !== currentProps.length) {
        cancelAnimation = true;
      }
    }
  }

  // Cancel animation (if required).
  if (cancelAnimation) animation.cancel();

  // Store animation callback.
  this._callback = isFunction(opts.onFinish) ? opts.onFinish : null;

  // If we have a running animation that does not need to be cancelled, let's
  // call it a day here and let it run.
  if (animation && !cancelAnimation) return;

  // Store target props and values to instance.
  currentProps.length = currentValues.length = 0;
  for (propName in propsTo) {
    currentProps.push(propName);
    currentValues.push(propsTo[propName]);
  }

  // Start the animation. We need to provide unprefixed property names to the
  // Web Animations polyfill if it is being used. If we have native Web
  // Animations available we need to provide prefixed properties instead.
  this._duration = duration;
  this._easing = easing;
  this._animation = element.animate(
    [
      createFrame(propsFrom, HAS_NATIVE_WEB_ANIMATIONS),
      createFrame(propsTo, HAS_NATIVE_WEB_ANIMATIONS),
    ],
    {
      duration: duration,
      easing: easing,
    }
  );
  this._animation.onfinish = this._onFinish;

  // Set the end styles. This makes sure that the element stays at the end
  // values after animation is finished.
  setStyles(element, propsTo);
};

/**
 * Stop instance's current animation if running.
 *
 * @public
 */
Animator.prototype.stop = function () {
  if (this._isDestroyed || !this._animation) return;
  this._animation.cancel();
  this._animation = this._callback = null;
  this._props.length = this._values.length = 0;
};

/**
 * Read the current values of the element's animated styles from the DOM.
 *
 * @public
 * @return {Object}
 */
Animator.prototype.getCurrentStyles = function () {
  return getCurrentStyles(element, currentProps);
};

/**
 * Check if the item is being animated currently.
 *
 * @public
 * @return {Boolean}
 */
Animator.prototype.isAnimating = function () {
  return !!this._animation;
};

/**
 * Destroy the instance and stop current animation if it is running.
 *
 * @public
 */
Animator.prototype.destroy = function () {
  if (this._isDestroyed) return;
  this.stop();
  this._element = null;
  this._isDestroyed = true;
};

/**
 * Private prototype methods
 * *************************
 */

/**
 * Animation end handler.
 *
 * @private
 */
Animator.prototype._onFinish = function () {
  var callback = this._callback;
  this._animation = this._callback = null;
  this._props.length = this._values.length = 0;
  callback && callback();
};

/**
 * Private helpers
 * ***************
 */

function createFrame(props, prefix) {
  var frame = {};
  for (var prop in props) {
    frame[prefix ? prop : getUnprefixedPropName(prop)] = props[prop];
  }
  return frame;
}

/**
 * Transform translateX and translateY value into CSS transform style
 * property's value.
 *
 * @param {Number} x
 * @param {Number} y
 * @returns {String}
 */
function getTranslateString(x, y) {
  return 'translateX(' + x + 'px) translateY(' + y + 'px)';
}

/**
 * Drag placeholder.
 *
 * @class
 * @param {Item} item
 */
function ItemDragPlaceholder(item) {
  this._item = item;
  this._animation = new Animator();
  this._element = null;
  this._className = '';
  this._didMigrate = false;
  this._resetAfterLayout = false;
  this._left = 0;
  this._top = 0;
  this._transX = 0;
  this._transY = 0;
  this._nextTransX = 0;
  this._nextTransY = 0;

  // Bind animation handlers.
  this._setupAnimation = this._setupAnimation.bind(this);
  this._startAnimation = this._startAnimation.bind(this);
  this._updateDimensions = this._updateDimensions.bind(this);

  // Bind event handlers.
  this._onLayoutStart = this._onLayoutStart.bind(this);
  this._onLayoutEnd = this._onLayoutEnd.bind(this);
  this._onReleaseEnd = this._onReleaseEnd.bind(this);
  this._onMigrate = this._onMigrate.bind(this);
  this._onHide = this._onHide.bind(this);
}

/**
 * Private prototype methods
 * *************************
 */

/**
 * Update placeholder's dimensions to match the item's dimensions.
 *
 * @private
 */
ItemDragPlaceholder.prototype._updateDimensions = function () {
  if (!this.isActive()) return;
  setStyles(this._element, {
    width: this._item._width + 'px',
    height: this._item._height + 'px',
  });
};

/**
 * Move placeholder to a new position.
 *
 * @private
 * @param {Item[]} items
 * @param {Boolean} isInstant
 */
ItemDragPlaceholder.prototype._onLayoutStart = function (items, isInstant) {
  var item = this._item;

  // If the item is not part of the layout anymore reset placeholder.
  if (items.indexOf(item) === -1) {
    this.reset();
    return;
  }

  var nextLeft = item._left;
  var nextTop = item._top;
  var currentLeft = this._left;
  var currentTop = this._top;

  // Keep track of item layout position.
  this._left = nextLeft;
  this._top = nextTop;

  // If item's position did not change, and the item did not migrate and the
  // layout is not instant and we can safely skip layout.
  if (!isInstant && !this._didMigrate && currentLeft === nextLeft && currentTop === nextTop) {
    return;
  }

  // Slots data is calculated with item margins added to them so we need to add
  // item's left and top margin to the slot data to get the placeholder's
  // next position.
  var nextX = nextLeft + item._marginLeft;
  var nextY = nextTop + item._marginTop;

  // Just snap to new position without any animations if no animation is
  // required or if placeholder moves between grids.
  var grid = item.getGrid();
  var animEnabled = !isInstant && grid._settings.layoutDuration > 0;
  if (!animEnabled || this._didMigrate) {
    // Cancel potential (queued) layout tick.
    cancelPlaceholderLayoutTick(item._id);

    // Snap placeholder to correct position.
    this._element.style[transformProp] = getTranslateString(nextX, nextY);
    this._animation.stop();

    // Move placeholder inside correct container after migration.
    if (this._didMigrate) {
      grid.getElement().appendChild(this._element);
      this._didMigrate = false;
    }

    return;
  }

  // Start the placeholder's layout animation in the next tick. We do this to
  // avoid layout thrashing.
  this._nextTransX = nextX;
  this._nextTransY = nextY;
  addPlaceholderLayoutTick(item._id, this._setupAnimation, this._startAnimation);
};

/**
 * Prepare placeholder for layout animation.
 *
 * @private
 */
ItemDragPlaceholder.prototype._setupAnimation = function () {
  if (!this.isActive()) return;

  var translate = getTranslate(this._element);
  this._transX = translate.x;
  this._transY = translate.y;
};

/**
 * Start layout animation.
 *
 * @private
 */
ItemDragPlaceholder.prototype._startAnimation = function () {
  if (!this.isActive()) return;

  var animation = this._animation;
  var currentX = this._transX;
  var currentY = this._transY;
  var nextX = this._nextTransX;
  var nextY = this._nextTransY;

  // If placeholder is already in correct position let's just stop animation
  // and be done with it.
  if (currentX === nextX && currentY === nextY) {
    if (animation.isAnimating()) {
      this._element.style[transformProp] = getTranslateString(nextX, nextY);
      animation.stop();
    }
    return;
  }

  // Otherwise let's start the animation.
  var settings = this._item.getGrid()._settings;
  var currentStyles = {};
  var targetStyles = {};
  currentStyles[transformProp] = getTranslateString(currentX, currentY);
  targetStyles[transformProp] = getTranslateString(nextX, nextY);
  animation.start(currentStyles, targetStyles, {
    duration: settings.layoutDuration,
    easing: settings.layoutEasing,
    onFinish: this._onLayoutEnd,
  });
};

/**
 * Layout end handler.
 *
 * @private
 */
ItemDragPlaceholder.prototype._onLayoutEnd = function () {
  if (this._resetAfterLayout) {
    this.reset();
  }
};

/**
 * Drag end handler. This handler is called when dragReleaseEnd event is
 * emitted and receives the event data as it's argument.
 *
 * @private
 * @param {Item} item
 */
ItemDragPlaceholder.prototype._onReleaseEnd = function (item) {
  if (item._id === this._item._id) {
    // If the placeholder is not animating anymore we can safely reset it.
    if (!this._animation.isAnimating()) {
      this.reset();
      return;
    }

    // If the placeholder item is still animating here, let's wait for it to
    // finish it's animation.
    this._resetAfterLayout = true;
  }
};

/**
 * Migration start handler. This handler is called when beforeSend event is
 * emitted and receives the event data as it's argument.
 *
 * @private
 * @param {Object} data
 * @param {Item} data.item
 * @param {Grid} data.fromGrid
 * @param {Number} data.fromIndex
 * @param {Grid} data.toGrid
 * @param {Number} data.toIndex
 */
ItemDragPlaceholder.prototype._onMigrate = function (data) {
  // Make sure we have a matching item.
  if (data.item !== this._item) return;

  var grid = this._item.getGrid();
  var nextGrid = data.toGrid;

  // Unbind listeners from current grid.
  grid.off(EVENT_DRAG_RELEASE_END, this._onReleaseEnd);
  grid.off(EVENT_LAYOUT_START, this._onLayoutStart);
  grid.off(EVENT_BEFORE_SEND, this._onMigrate);
  grid.off(EVENT_HIDE_START, this._onHide);

  // Bind listeners to the next grid.
  nextGrid.on(EVENT_DRAG_RELEASE_END, this._onReleaseEnd);
  nextGrid.on(EVENT_LAYOUT_START, this._onLayoutStart);
  nextGrid.on(EVENT_BEFORE_SEND, this._onMigrate);
  nextGrid.on(EVENT_HIDE_START, this._onHide);

  // Mark the item as migrated.
  this._didMigrate = true;
};

/**
 * Reset placeholder if the associated item is hidden.
 *
 * @private
 * @param {Item[]} items
 */
ItemDragPlaceholder.prototype._onHide = function (items) {
  if (items.indexOf(this._item) > -1) this.reset();
};

/**
 * Public prototype methods
 * ************************
 */

/**
 * Create placeholder. Note that this method only writes to DOM and does not
 * read anything from DOM so it should not cause any additional layout
 * thrashing when it's called at the end of the drag start procedure.
 *
 * @public
 */
ItemDragPlaceholder.prototype.create = function () {
  // If we already have placeholder set up we can skip the initiation logic.
  if (this.isActive()) {
    this._resetAfterLayout = false;
    return;
  }

  var item = this._item;
  var grid = item.getGrid();
  var settings = grid._settings;
  var animation = this._animation;

  // Keep track of layout position.
  this._left = item._left;
  this._top = item._top;

  // Create placeholder element.
  var element;
  if (isFunction(settings.dragPlaceholder.createElement)) {
    element = settings.dragPlaceholder.createElement(item);
  } else {
    element = document.createElement('div');
  }
  this._element = element;

  // Update element to animation instance.
  animation._element = element;

  // Add placeholder class to the placeholder element.
  this._className = settings.itemPlaceholderClass || '';
  if (this._className) {
    addClass(element, this._className);
  }

  // Set initial styles.
  setStyles(element, {
    position: 'absolute',
    left: '0px',
    top: '0px',
    width: item._width + 'px',
    height: item._height + 'px',
  });

  // Set initial position.
  element.style[transformProp] = getTranslateString(
    item._left + item._marginLeft,
    item._top + item._marginTop
  );

  // Bind event listeners.
  grid.on(EVENT_LAYOUT_START, this._onLayoutStart);
  grid.on(EVENT_DRAG_RELEASE_END, this._onReleaseEnd);
  grid.on(EVENT_BEFORE_SEND, this._onMigrate);
  grid.on(EVENT_HIDE_START, this._onHide);

  // onCreate hook.
  if (isFunction(settings.dragPlaceholder.onCreate)) {
    settings.dragPlaceholder.onCreate(item, element);
  }

  // Insert the placeholder element to the grid.
  grid.getElement().appendChild(element);
};

/**
 * Reset placeholder data.
 *
 * @public
 */
ItemDragPlaceholder.prototype.reset = function () {
  if (!this.isActive()) return;

  var element = this._element;
  var item = this._item;
  var grid = item.getGrid();
  var settings = grid._settings;
  var animation = this._animation;

  // Reset flag.
  this._resetAfterLayout = false;

  // Cancel potential (queued) layout tick.
  cancelPlaceholderLayoutTick(item._id);
  cancelPlaceholderResizeTick(item._id);

  // Reset animation instance.
  animation.stop();
  animation._element = null;

  // Unbind event listeners.
  grid.off(EVENT_DRAG_RELEASE_END, this._onReleaseEnd);
  grid.off(EVENT_LAYOUT_START, this._onLayoutStart);
  grid.off(EVENT_BEFORE_SEND, this._onMigrate);
  grid.off(EVENT_HIDE_START, this._onHide);

  // Remove placeholder class from the placeholder element.
  if (this._className) {
    removeClass(element, this._className);
    this._className = '';
  }

  // Remove element.
  element.parentNode.removeChild(element);
  this._element = null;

  // onRemove hook. Note that here we use the current grid's onRemove callback
  // so if the item has migrated during drag the onRemove method will not be
  // the originating grid's method.
  if (isFunction(settings.dragPlaceholder.onRemove)) {
    settings.dragPlaceholder.onRemove(item, element);
  }
};

/**
 * Check if placeholder is currently active (visible).
 *
 * @public
 * @returns {Boolean}
 */
ItemDragPlaceholder.prototype.isActive = function () {
  return !!this._element;
};

/**
 * Get placeholder element.
 *
 * @public
 * @returns {?HTMLElement}
 */
ItemDragPlaceholder.prototype.getElement = function () {
  return this._element;
};

/**
 * Update placeholder's dimensions to match the item's dimensions. Note that
 * the updating is done asynchronously in the next tick to avoid layout
 * thrashing.
 *
 * @public
 */
ItemDragPlaceholder.prototype.updateDimensions = function () {
  if (!this.isActive()) return;
  addPlaceholderResizeTick(this._item._id, this._updateDimensions);
};

/**
 * Destroy placeholder instance.
 *
 * @public
 */
ItemDragPlaceholder.prototype.destroy = function () {
  this.reset();
  this._animation.destroy();
  this._item = this._animation = null;
};

/**
 * The release process handler constructor. Although this might seem as proper
 * fit for the drag process this needs to be separated into it's own logic
 * because there might be a scenario where drag is disabled, but the release
 * process still needs to be implemented (dragging from a grid to another).
 *
 * @class
 * @param {Item} item
 */
function ItemDragRelease(item) {
  this._item = item;
  this._isActive = false;
  this._isDestroyed = false;
  this._isPositioningStarted = false;
  this._containerDiffX = 0;
  this._containerDiffY = 0;
}

/**
 * Public prototype methods
 * ************************
 */

/**
 * Start the release process of an item.
 *
 * @public
 */
ItemDragRelease.prototype.start = function () {
  if (this._isDestroyed || this._isActive) return;

  var item = this._item;
  var grid = item.getGrid();
  var settings = grid._settings;

  this._isActive = true;
  addClass(item._element, settings.itemReleasingClass);
  if (!settings.dragRelease.useDragContainer) {
    this._placeToGrid();
  }
  grid._emit(EVENT_DRAG_RELEASE_START, item);

  // Let's start layout manually _only_ if there is no unfinished layout in
  // about to finish.
  if (!grid._nextLayoutData) item._layout.start(false);
};

/**
 * End the release process of an item. This method can be used to abort an
 * ongoing release process (animation) or finish the release process.
 *
 * @public
 * @param {Boolean} [abort=false]
 *  - Should the release be aborted? When true, the release end event won't be
 *    emitted. Set to true only when you need to abort the release process
 *    while the item is animating to it's position.
 * @param {Number} [left]
 *  - The element's current translateX value (optional).
 * @param {Number} [top]
 *  - The element's current translateY value (optional).
 */
ItemDragRelease.prototype.stop = function (abort, left, top) {
  if (this._isDestroyed || !this._isActive) return;

  var item = this._item;
  var grid = item.getGrid();

  if (!abort && (left === undefined || top === undefined)) {
    left = item._left;
    top = item._top;
  }

  var didReparent = this._placeToGrid(left, top);
  this._reset(didReparent);

  if (!abort) grid._emit(EVENT_DRAG_RELEASE_END, item);
};

ItemDragRelease.prototype.isJustReleased = function () {
  return this._isActive && this._isPositioningStarted === false;
};

/**
 * Destroy instance.
 *
 * @public
 */
ItemDragRelease.prototype.destroy = function () {
  if (this._isDestroyed) return;
  this.stop(true);
  this._item = null;
  this._isDestroyed = true;
};

/**
 * Private prototype methods
 * *************************
 */

/**
 * Move the element back to the grid container element if it does not exist
 * there already.
 *
 * @private
 * @param {Number} [left]
 *  - The element's current translateX value (optional).
 * @param {Number} [top]
 *  - The element's current translateY value (optional).
 * @returns {Boolean}
 *   - Returns `true` if the element was reparented.
 */
ItemDragRelease.prototype._placeToGrid = function (left, top) {
  if (this._isDestroyed) return;

  var item = this._item;
  var element = item._element;
  var container = item.getGrid()._element;
  var didReparent = false;

  if (element.parentNode !== container) {
    if (left === undefined || top === undefined) {
      var translate = getTranslate(element);
      left = translate.x - this._containerDiffX;
      top = translate.y - this._containerDiffY;
    }

    container.appendChild(element);
    item._setTranslate(left, top);
    didReparent = true;
  }

  this._containerDiffX = 0;
  this._containerDiffY = 0;

  return didReparent;
};

/**
 * Reset data and remove releasing class.
 *
 * @private
 * @param {Boolean} [needsReflow]
 */
ItemDragRelease.prototype._reset = function (needsReflow) {
  if (this._isDestroyed) return;

  var item = this._item;
  var releasingClass = item.getGrid()._settings.itemReleasingClass;

  this._isActive = false;
  this._isPositioningStarted = false;
  this._containerDiffX = 0;
  this._containerDiffY = 0;

  // If the element was just reparented we need to do a forced reflow to remove
  // the class gracefully.
  if (releasingClass) {
    // eslint-disable-next-line
    if (needsReflow) item._element.clientWidth;
    removeClass(item._element, releasingClass);
  }
};

var MIN_ANIMATION_DISTANCE = 2;

/**
 * Layout manager for Item instance, handles the positioning of an item.
 *
 * @class
 * @param {Item} item
 */
function ItemLayout(item) {
  var element = item._element;
  var elementStyle = element.style;

  this._item = item;
  this._isActive = false;
  this._isDestroyed = false;
  this._isInterrupted = false;
  this._currentStyles = {};
  this._targetStyles = {};
  this._nextLeft = 0;
  this._nextTop = 0;
  this._offsetLeft = 0;
  this._offsetTop = 0;
  this._skipNextAnimation = false;
  this._animOptions = {
    onFinish: this._finish.bind(this),
    duration: 0,
    easing: 0,
  };

  // Set element's initial position styles.
  elementStyle.left = '0px';
  elementStyle.top = '0px';
  item._setTranslate(0, 0);

  this._animation = new Animator(element);
  this._queue = 'layout-' + item._id;

  // Bind animation handlers and finish method.
  this._setupAnimation = this._setupAnimation.bind(this);
  this._startAnimation = this._startAnimation.bind(this);
}

/**
 * Public prototype methods
 * ************************
 */

/**
 * Start item layout based on it's current data.
 *
 * @public
 * @param {Boolean} instant
 * @param {Function} [onFinish]
 */
ItemLayout.prototype.start = function (instant, onFinish) {
  if (this._isDestroyed) return;

  var item = this._item;
  var release = item._dragRelease;
  var gridSettings = item.getGrid()._settings;
  var isPositioning = this._isActive;
  var isJustReleased = release.isJustReleased();
  var animDuration = isJustReleased
    ? gridSettings.dragRelease.duration
    : gridSettings.layoutDuration;
  var animEasing = isJustReleased ? gridSettings.dragRelease.easing : gridSettings.layoutEasing;
  var animEnabled = !instant && !this._skipNextAnimation && animDuration > 0;

  // If the item is currently positioning cancel potential queued layout tick
  // and process current layout callback queue with interrupted flag on.
  if (isPositioning) {
    cancelLayoutTick(item._id);
    item._emitter.burst(this._queue, true, item);
  }

  // Mark release positioning as started.
  if (isJustReleased) release._isPositioningStarted = true;

  // Push the callback to the callback queue.
  if (isFunction(onFinish)) {
    item._emitter.on(this._queue, onFinish);
  }

  // Reset animation skipping flag.
  this._skipNextAnimation = false;

  // If no animations are needed, easy peasy!
  if (!animEnabled) {
    this._updateOffsets();
    item._setTranslate(this._nextLeft, this._nextTop);
    this._animation.stop();
    this._finish();
    return;
  }

  // Let's make sure an ongoing animation's callback is cancelled before going
  // further. Without this there's a chance that the animation will finish
  // before the next tick and mess up our logic.
  if (this._animation.isAnimating()) {
    this._animation._animation.onfinish = null;
  }

  // Kick off animation to be started in the next tick.
  this._isActive = true;
  this._animOptions.easing = animEasing;
  this._animOptions.duration = animDuration;
  this._isInterrupted = isPositioning;
  addLayoutTick(item._id, this._setupAnimation, this._startAnimation);
};

/**
 * Stop item's position animation if it is currently animating.
 *
 * @public
 * @param {Boolean} processCallbackQueue
 * @param {Number} [left]
 * @param {Number} [top]
 */
ItemLayout.prototype.stop = function (processCallbackQueue, left, top) {
  if (this._isDestroyed || !this._isActive) return;

  var item = this._item;

  // Cancel animation init.
  cancelLayoutTick(item._id);

  // Stop animation.
  if (this._animation.isAnimating()) {
    if (left === undefined || top === undefined) {
      var translate = getTranslate(item._element);
      left = translate.x;
      top = translate.y;
    }
    item._setTranslate(left, top);
    this._animation.stop();
  }

  // Remove positioning class.
  removeClass(item._element, item.getGrid()._settings.itemPositioningClass);

  // Reset active state.
  this._isActive = false;

  // Process callback queue if needed.
  if (processCallbackQueue) {
    item._emitter.burst(this._queue, true, item);
  }
};

/**
 * Destroy the instance and stop current animation if it is running.
 *
 * @public
 */
ItemLayout.prototype.destroy = function () {
  if (this._isDestroyed) return;

  var elementStyle = this._item._element.style;

  this.stop(true, 0, 0);
  this._item._emitter.clear(this._queue);
  this._animation.destroy();

  elementStyle[transformProp] = '';
  elementStyle.left = '';
  elementStyle.top = '';

  this._item = null;
  this._currentStyles = null;
  this._targetStyles = null;
  this._animOptions = null;
  this._isDestroyed = true;
};

/**
 * Private prototype methods
 * *************************
 */

/**
 * Calculate and update item's current layout offset data.
 *
 * @private
 */
ItemLayout.prototype._updateOffsets = function () {
  if (this._isDestroyed) return;

  var item = this._item;
  var migrate = item._migrate;
  var release = item._dragRelease;

  this._offsetLeft = release._isActive
    ? release._containerDiffX
    : migrate._isActive
    ? migrate._containerDiffX
    : 0;

  this._offsetTop = release._isActive
    ? release._containerDiffY
    : migrate._isActive
    ? migrate._containerDiffY
    : 0;

  this._nextLeft = this._item._left + this._offsetLeft;
  this._nextTop = this._item._top + this._offsetTop;
};

/**
 * Finish item layout procedure.
 *
 * @private
 */
ItemLayout.prototype._finish = function () {
  if (this._isDestroyed) return;

  var item = this._item;
  var migrate = item._migrate;
  var release = item._dragRelease;

  // Update internal translate values.
  item._tX = this._nextLeft;
  item._tY = this._nextTop;

  // Mark the item as inactive and remove positioning classes.
  if (this._isActive) {
    this._isActive = false;
    removeClass(item._element, item.getGrid()._settings.itemPositioningClass);
  }

  // Finish up release and migration.
  if (release._isActive) release.stop();
  if (migrate._isActive) migrate.stop();

  // Process the callback queue.
  item._emitter.burst(this._queue, false, item);
};

/**
 * Prepare item for layout animation.
 *
 * @private
 */
ItemLayout.prototype._setupAnimation = function () {
  var item = this._item;
  if (item._tX === undefined || item._tY === undefined) {
    var translate = getTranslate(item._element);
    item._tX = translate.x;
    item._tY = translate.y;
  }
};

/**
 * Start layout animation.
 *
 * @private
 */
ItemLayout.prototype._startAnimation = function () {
  var item = this._item;
  var settings = item.getGrid()._settings;
  var isInstant = this._animOptions.duration <= 0;

  // Let's update the offset data and target styles.
  this._updateOffsets();

  var xDiff = Math.abs(item._left - (item._tX - this._offsetLeft));
  var yDiff = Math.abs(item._top - (item._tY - this._offsetTop));

  // If there is no need for animation or if the item is already in correct
  // position (or near it) let's finish the process early.
  if (isInstant || (xDiff < MIN_ANIMATION_DISTANCE && yDiff < MIN_ANIMATION_DISTANCE)) {
    if (xDiff || yDiff || this._isInterrupted) {
      item._setTranslate(this._nextLeft, this._nextTop);
    }
    this._animation.stop();
    this._finish();
    return;
  }

  // Set item's positioning class if needed.
  if (!this._isInterrupted) {
    addClass(item._element, settings.itemPositioningClass);
  }

  // Get current/next styles for animation.
  this._currentStyles[transformProp] = getTranslateString(item._tX, item._tY);
  this._targetStyles[transformProp] = getTranslateString(this._nextLeft, this._nextTop);

  // Set internal translation values to undefined for the duration of the
  // animation since they will be changing on each animation frame for the
  // duration of the animation and tracking them would mean reading the DOM on
  // each frame, which is pretty darn expensive.
  item._tX = item._tY = undefined;

  // Start animation.
  this._animation.start(this._currentStyles, this._targetStyles, this._animOptions);
};

/**
 * The migrate process handler constructor.
 *
 * @class
 * @param {Item} item
 */
function ItemMigrate(item) {
  // Private props.
  this._item = item;
  this._isActive = false;
  this._isDestroyed = false;
  this._container = false;
  this._containerDiffX = 0;
  this._containerDiffY = 0;
}

/**
 * Public prototype methods
 * ************************
 */

/**
 * Start the migrate process of an item.
 *
 * @public
 * @param {Grid} targetGrid
 * @param {(HTMLElement|Number|Item)} position
 * @param {HTMLElement} [container]
 */
ItemMigrate.prototype.start = function (targetGrid, position, container) {
  if (this._isDestroyed) return;

  var item = this._item;
  var element = item._element;
  var isActive = item.isActive();
  var isVisible = item.isVisible();
  var grid = item.getGrid();
  var settings = grid._settings;
  var targetSettings = targetGrid._settings;
  var targetElement = targetGrid._element;
  var targetItems = targetGrid._items;
  var currentIndex = grid._items.indexOf(item);
  var targetContainer = container || document.body;
  var targetIndex;
  var targetItem;
  var currentContainer;
  var offsetDiff;
  var containerDiff;
  var translate;
  var translateX;
  var translateY;
  var currentVisClass;
  var nextVisClass;

  // Get target index.
  if (typeof position === 'number') {
    targetIndex = normalizeArrayIndex(targetItems, position, 1);
  } else {
    targetItem = targetGrid.getItem(position);
    if (!targetItem) return;
    targetIndex = targetItems.indexOf(targetItem);
  }

  // Get current translateX and translateY values if needed.
  if (item.isPositioning() || this._isActive || item.isReleasing()) {
    translate = getTranslate(element);
    translateX = translate.x;
    translateY = translate.y;
  }

  // Abort current positioning.
  if (item.isPositioning()) {
    item._layout.stop(true, translateX, translateY);
  }

  // Abort current migration.
  if (this._isActive) {
    translateX -= this._containerDiffX;
    translateY -= this._containerDiffY;
    this.stop(true, translateX, translateY);
  }

  // Abort current release.
  if (item.isReleasing()) {
    translateX -= item._dragRelease._containerDiffX;
    translateY -= item._dragRelease._containerDiffY;
    item._dragRelease.stop(true, translateX, translateY);
  }

  // Stop current visibility animation.
  item._visibility.stop(true);

  // Destroy current drag.
  if (item._drag) item._drag.destroy();

  // Emit beforeSend event.
  if (grid._hasListeners(EVENT_BEFORE_SEND)) {
    grid._emit(EVENT_BEFORE_SEND, {
      item: item,
      fromGrid: grid,
      fromIndex: currentIndex,
      toGrid: targetGrid,
      toIndex: targetIndex,
    });
  }

  // Emit beforeReceive event.
  if (targetGrid._hasListeners(EVENT_BEFORE_RECEIVE)) {
    targetGrid._emit(EVENT_BEFORE_RECEIVE, {
      item: item,
      fromGrid: grid,
      fromIndex: currentIndex,
      toGrid: targetGrid,
      toIndex: targetIndex,
    });
  }

  // Update item class.
  if (settings.itemClass !== targetSettings.itemClass) {
    removeClass(element, settings.itemClass);
    addClass(element, targetSettings.itemClass);
  }

  // Update visibility class.
  currentVisClass = isVisible ? settings.itemVisibleClass : settings.itemHiddenClass;
  nextVisClass = isVisible ? targetSettings.itemVisibleClass : targetSettings.itemHiddenClass;
  if (currentVisClass !== nextVisClass) {
    removeClass(element, currentVisClass);
    addClass(element, nextVisClass);
  }

  // Move item instance from current grid to target grid.
  grid._items.splice(currentIndex, 1);
  arrayInsert(targetItems, item, targetIndex);

  // Update item's grid id reference.
  item._gridId = targetGrid._id;

  // If item is active we need to move the item inside the target container for
  // the duration of the (potential) animation if it's different than the
  // current container.
  if (isActive) {
    currentContainer = element.parentNode;
    if (targetContainer !== currentContainer) {
      targetContainer.appendChild(element);
      offsetDiff = getOffsetDiff(targetContainer, currentContainer, true);
      if (!translate) {
        translate = getTranslate(element);
        translateX = translate.x;
        translateY = translate.y;
      }
      item._setTranslate(translateX + offsetDiff.left, translateY + offsetDiff.top);
    }
  }
  // If item is not active let's just append it to the target grid's element.
  else {
    targetElement.appendChild(element);
  }

  // Update child element's styles to reflect the current visibility state.
  item._visibility.setStyles(
    isVisible ? targetSettings.visibleStyles : targetSettings.hiddenStyles
  );

  // Get offset diff for the migration data, if the item is active.
  if (isActive) {
    containerDiff = getOffsetDiff(targetContainer, targetElement, true);
  }

  // Update item's cached dimensions.
  item._refreshDimensions();

  // Reset item's sort data.
  item._sortData = null;

  // Create new drag handler.
  item._drag = targetSettings.dragEnabled ? new ItemDrag(item) : null;

  // Setup migration data.
  if (isActive) {
    this._isActive = true;
    this._container = targetContainer;
    this._containerDiffX = containerDiff.left;
    this._containerDiffY = containerDiff.top;
  } else {
    this._isActive = false;
    this._container = null;
    this._containerDiffX = 0;
    this._containerDiffY = 0;
  }

  // Emit send event.
  if (grid._hasListeners(EVENT_SEND)) {
    grid._emit(EVENT_SEND, {
      item: item,
      fromGrid: grid,
      fromIndex: currentIndex,
      toGrid: targetGrid,
      toIndex: targetIndex,
    });
  }

  // Emit receive event.
  if (targetGrid._hasListeners(EVENT_RECEIVE)) {
    targetGrid._emit(EVENT_RECEIVE, {
      item: item,
      fromGrid: grid,
      fromIndex: currentIndex,
      toGrid: targetGrid,
      toIndex: targetIndex,
    });
  }
};

/**
 * End the migrate process of an item. This method can be used to abort an
 * ongoing migrate process (animation) or finish the migrate process.
 *
 * @public
 * @param {Boolean} [abort=false]
 *  - Should the migration be aborted?
 * @param {Number} [left]
 *  - The element's current translateX value (optional).
 * @param {Number} [top]
 *  - The element's current translateY value (optional).
 */
ItemMigrate.prototype.stop = function (abort, left, top) {
  if (this._isDestroyed || !this._isActive) return;

  var item = this._item;
  var element = item._element;
  var grid = item.getGrid();
  var gridElement = grid._element;
  var translate;

  if (this._container !== gridElement) {
    if (left === undefined || top === undefined) {
      if (abort) {
        translate = getTranslate(element);
        left = translate.x - this._containerDiffX;
        top = translate.y - this._containerDiffY;
      } else {
        left = item._left;
        top = item._top;
      }
    }

    gridElement.appendChild(element);
    item._setTranslate(left, top);
  }

  this._isActive = false;
  this._container = null;
  this._containerDiffX = 0;
  this._containerDiffY = 0;
};

/**
 * Destroy instance.
 *
 * @public
 */
ItemMigrate.prototype.destroy = function () {
  if (this._isDestroyed) return;
  this.stop(true);
  this._item = null;
  this._isDestroyed = true;
};

/**
 * Visibility manager for Item instance, handles visibility of an item.
 *
 * @class
 * @param {Item} item
 */
function ItemVisibility(item) {
  var isActive = item._isActive;
  var element = item._element;
  var childElement = element.children[0];
  var settings = item.getGrid()._settings;

  if (!childElement) {
    throw new Error('No valid child element found within item element.');
  }

  this._item = item;
  this._isDestroyed = false;
  this._isHidden = !isActive;
  this._isHiding = false;
  this._isShowing = false;
  this._childElement = childElement;
  this._currentStyleProps = [];
  this._animation = new Animator(childElement);
  this._queue = 'visibility-' + item._id;
  this._finishShow = this._finishShow.bind(this);
  this._finishHide = this._finishHide.bind(this);

  element.style.display = isActive ? '' : 'none';
  addClass(element, isActive ? settings.itemVisibleClass : settings.itemHiddenClass);
  this.setStyles(isActive ? settings.visibleStyles : settings.hiddenStyles);
}

/**
 * Public prototype methods
 * ************************
 */

/**
 * Show item.
 *
 * @public
 * @param {Boolean} instant
 * @param {Function} [onFinish]
 */
ItemVisibility.prototype.show = function (instant, onFinish) {
  if (this._isDestroyed) return;

  var item = this._item;
  var element = item._element;
  var callback = isFunction(onFinish) ? onFinish : null;
  var grid = item.getGrid();
  var settings = grid._settings;

  // If item is visible call the callback and be done with it.
  if (!this._isShowing && !this._isHidden) {
    callback && callback(false, item);
    return;
  }

  // If item is showing and does not need to be shown instantly, let's just
  // push callback to the callback queue and be done with it.
  if (this._isShowing && !instant) {
    callback && item._emitter.on(this._queue, callback);
    return;
  }

  // If the item is hiding or hidden process the current visibility callback
  // queue with the interrupted flag active, update classes and set display
  // to block if necessary.
  if (!this._isShowing) {
    item._emitter.burst(this._queue, true, item);
    removeClass(element, settings.itemHiddenClass);
    addClass(element, settings.itemVisibleClass);
    if (!this._isHiding) element.style.display = '';
  }

  // Push callback to the callback queue.
  callback && item._emitter.on(this._queue, callback);

  // Update visibility states.
  this._isShowing = true;
  this._isHiding = this._isHidden = false;

  // Finally let's start show animation.
  this._startAnimation(true, instant, this._finishShow);
};

/**
 * Hide item.
 *
 * @public
 * @param {Boolean} instant
 * @param {Function} [onFinish]
 */
ItemVisibility.prototype.hide = function (instant, onFinish) {
  if (this._isDestroyed) return;

  var item = this._item;
  var element = item._element;
  var callback = isFunction(onFinish) ? onFinish : null;
  var grid = item.getGrid();
  var settings = grid._settings;

  // If item is already hidden call the callback and be done with it.
  if (!this._isHiding && this._isHidden) {
    callback && callback(false, item);
    return;
  }

  // If item is hiding and does not need to be hidden instantly, let's just
  // push callback to the callback queue and be done with it.
  if (this._isHiding && !instant) {
    callback && item._emitter.on(this._queue, callback);
    return;
  }

  // If the item is showing or visible process the current visibility callback
  // queue with the interrupted flag active, update classes and set display
  // to block if necessary.
  if (!this._isHiding) {
    item._emitter.burst(this._queue, true, item);
    addClass(element, settings.itemHiddenClass);
    removeClass(element, settings.itemVisibleClass);
  }

  // Push callback to the callback queue.
  callback && item._emitter.on(this._queue, callback);

  // Update visibility states.
  this._isHidden = this._isHiding = true;
  this._isShowing = false;

  // Finally let's start hide animation.
  this._startAnimation(false, instant, this._finishHide);
};

/**
 * Stop current hiding/showing process.
 *
 * @public
 * @param {Boolean} processCallbackQueue
 */
ItemVisibility.prototype.stop = function (processCallbackQueue) {
  if (this._isDestroyed) return;
  if (!this._isHiding && !this._isShowing) return;

  var item = this._item;

  cancelVisibilityTick(item._id);
  this._animation.stop();
  if (processCallbackQueue) {
    item._emitter.burst(this._queue, true, item);
  }
};

/**
 * Reset all existing visibility styles and apply new visibility styles to the
 * visibility element. This method should be used to set styles when there is a
 * chance that the current style properties differ from the new ones (basically
 * on init and on migrations).
 *
 * @public
 * @param {Object} styles
 */
ItemVisibility.prototype.setStyles = function (styles) {
  var childElement = this._childElement;
  var currentStyleProps = this._currentStyleProps;
  this._removeCurrentStyles();
  for (var prop in styles) {
    currentStyleProps.push(prop);
    childElement.style[prop] = styles[prop];
  }
};

/**
 * Destroy the instance and stop current animation if it is running.
 *
 * @public
 */
ItemVisibility.prototype.destroy = function () {
  if (this._isDestroyed) return;

  var item = this._item;
  var element = item._element;
  var grid = item.getGrid();
  var settings = grid._settings;

  this.stop(true);
  item._emitter.clear(this._queue);
  this._animation.destroy();
  this._removeCurrentStyles();
  removeClass(element, settings.itemVisibleClass);
  removeClass(element, settings.itemHiddenClass);
  element.style.display = '';

  // Reset state.
  this._isHiding = this._isShowing = false;
  this._isDestroyed = this._isHidden = true;
};

/**
 * Private prototype methods
 * *************************
 */

/**
 * Start visibility animation.
 *
 * @private
 * @param {Boolean} toVisible
 * @param {Boolean} [instant]
 * @param {Function} [onFinish]
 */
ItemVisibility.prototype._startAnimation = function (toVisible, instant, onFinish) {
  if (this._isDestroyed) return;

  var item = this._item;
  var animation = this._animation;
  var childElement = this._childElement;
  var settings = item.getGrid()._settings;
  var targetStyles = toVisible ? settings.visibleStyles : settings.hiddenStyles;
  var duration = toVisible ? settings.showDuration : settings.hideDuration;
  var easing = toVisible ? settings.showEasing : settings.hideEasing;
  var isInstant = instant || duration <= 0;
  var currentStyles;

  // No target styles? Let's quit early.
  if (!targetStyles) {
    onFinish && onFinish();
    return;
  }

  // Cancel queued visibility tick.
  cancelVisibilityTick(item._id);

  // If we need to apply the styles instantly without animation.
  if (isInstant) {
    setStyles(childElement, targetStyles);
    animation.stop();
    onFinish && onFinish();
    return;
  }

  // Let's make sure an ongoing animation's callback is cancelled before going
  // further. Without this there's a chance that the animation will finish
  // before the next tick and mess up our logic.
  if (animation.isAnimating()) {
    animation._animation.onfinish = null;
  }

  // Start the animation in the next tick (to avoid layout thrashing).
  addVisibilityTick(
    item._id,
    function () {
      currentStyles = getCurrentStyles(childElement, targetStyles);
    },
    function () {
      animation.start(currentStyles, targetStyles, {
        duration: duration,
        easing: easing,
        onFinish: onFinish,
      });
    }
  );
};

/**
 * Finish show procedure.
 *
 * @private
 */
ItemVisibility.prototype._finishShow = function () {
  if (this._isHidden) return;
  this._isShowing = false;
  this._item._emitter.burst(this._queue, false, this._item);
};

/**
 * Finish hide procedure.
 *
 * @private
 */
ItemVisibility.prototype._finishHide = function () {
  if (!this._isHidden) return;
  var item = this._item;
  this._isHiding = false;
  item._layout.stop(true, 0, 0);
  item._element.style.display = 'none';
  item._emitter.burst(this._queue, false, item);
};

/**
 * Remove currently applied visibility related inline style properties.
 *
 * @private
 */
ItemVisibility.prototype._removeCurrentStyles = function () {
  var childElement = this._childElement;
  var currentStyleProps = this._currentStyleProps;

  for (var i = 0; i < currentStyleProps.length; i++) {
    childElement.style[currentStyleProps[i]] = '';
  }

  currentStyleProps.length = 0;
};

var id = 0;

/**
 * Returns a unique numeric id (increments a base value on every call).
 * @returns {Number}
 */
function createUid() {
  return ++id;
}

/**
 * Creates a new Item instance for a Grid instance.
 *
 * @class
 * @param {Grid} grid
 * @param {HTMLElement} element
 * @param {Boolean} [isActive]
 */
function Item(grid, element, isActive) {
  var settings = grid._settings;

  // Store item/element pair to a map (for faster item querying by element).
  if (ITEM_ELEMENT_MAP) {
    if (ITEM_ELEMENT_MAP.has(element)) {
      throw new Error('You can only create one Muuri Item per element!');
    } else {
      ITEM_ELEMENT_MAP.set(element, this);
    }
  }

  this._id = createUid();
  this._gridId = grid._id;
  this._element = element;
  this._isDestroyed = false;
  this._left = 0;
  this._top = 0;
  this._width = 0;
  this._height = 0;
  this._marginLeft = 0;
  this._marginRight = 0;
  this._marginTop = 0;
  this._marginBottom = 0;
  this._tX = undefined;
  this._tY = undefined;
  this._sortData = null;
  this._emitter = new Emitter();

  // If the provided item element is not a direct child of the grid container
  // element, append it to the grid container. Note, we are indeed reading the
  // DOM here but it's a property that does not cause reflowing.
  if (element.parentNode !== grid._element) {
    grid._element.appendChild(element);
  }

  // Set item class.
  addClass(element, settings.itemClass);

  // If isActive is not defined, let's try to auto-detect it. Note, we are
  // indeed reading the DOM here but it's a property that does not cause
  // reflowing.
  if (typeof isActive !== 'boolean') {
    isActive = getStyle(element, 'display') !== 'none';
  }

  // Set up active state (defines if the item is considered part of the layout
  // or not).
  this._isActive = isActive;

  // Setup visibility handler.
  this._visibility = new ItemVisibility(this);

  // Set up layout handler.
  this._layout = new ItemLayout(this);

  // Set up migration handler data.
  this._migrate = new ItemMigrate(this);

  // Set up drag handler.
  this._drag = settings.dragEnabled ? new ItemDrag(this) : null;

  // Set up release handler. Note that although this is fully linked to dragging
  // this still needs to be always instantiated to handle migration scenarios
  // correctly.
  this._dragRelease = new ItemDragRelease(this);

  // Set up drag placeholder handler. Note that although this is fully linked to
  // dragging this still needs to be always instantiated to handle migration
  // scenarios correctly.
  this._dragPlaceholder = new ItemDragPlaceholder(this);

  // Note! You must call the following methods before you start using the
  // instance. They are deliberately not called in the end as it would cause
  // potentially a massive amount of reflows if multiple items were instantiated
  // in a loop.
  // this._refreshDimensions();
  // this._refreshSortData();
}

/**
 * Public prototype methods
 * ************************
 */

/**
 * Get the instance grid reference.
 *
 * @public
 * @returns {Grid}
 */
Item.prototype.getGrid = function () {
  return GRID_INSTANCES[this._gridId];
};

/**
 * Get the instance element.
 *
 * @public
 * @returns {HTMLElement}
 */
Item.prototype.getElement = function () {
  return this._element;
};

/**
 * Get instance element's cached width.
 *
 * @public
 * @returns {Number}
 */
Item.prototype.getWidth = function () {
  return this._width;
};

/**
 * Get instance element's cached height.
 *
 * @public
 * @returns {Number}
 */
Item.prototype.getHeight = function () {
  return this._height;
};

/**
 * Get instance element's cached margins.
 *
 * @public
 * @returns {Object}
 *   - The returned object contains left, right, top and bottom properties
 *     which indicate the item element's cached margins.
 */
Item.prototype.getMargin = function () {
  return {
    left: this._marginLeft,
    right: this._marginRight,
    top: this._marginTop,
    bottom: this._marginBottom,
  };
};

/**
 * Get instance element's cached position.
 *
 * @public
 * @returns {Object}
 *   - The returned object contains left and top properties which indicate the
 *     item element's cached position in the grid.
 */
Item.prototype.getPosition = function () {
  return {
    left: this._left,
    top: this._top,
  };
};

/**
 * Is the item active?
 *
 * @public
 * @returns {Boolean}
 */
Item.prototype.isActive = function () {
  return this._isActive;
};

/**
 * Is the item visible?
 *
 * @public
 * @returns {Boolean}
 */
Item.prototype.isVisible = function () {
  return !!this._visibility && !this._visibility._isHidden;
};

/**
 * Is the item being animated to visible?
 *
 * @public
 * @returns {Boolean}
 */
Item.prototype.isShowing = function () {
  return !!(this._visibility && this._visibility._isShowing);
};

/**
 * Is the item being animated to hidden?
 *
 * @public
 * @returns {Boolean}
 */
Item.prototype.isHiding = function () {
  return !!(this._visibility && this._visibility._isHiding);
};

/**
 * Is the item positioning?
 *
 * @public
 * @returns {Boolean}
 */
Item.prototype.isPositioning = function () {
  return !!(this._layout && this._layout._isActive);
};

/**
 * Is the item being dragged (or queued for dragging)?
 *
 * @public
 * @returns {Boolean}
 */
Item.prototype.isDragging = function () {
  return !!(this._drag && this._drag._isActive);
};

/**
 * Is the item being released?
 *
 * @public
 * @returns {Boolean}
 */
Item.prototype.isReleasing = function () {
  return !!(this._dragRelease && this._dragRelease._isActive);
};

/**
 * Is the item destroyed?
 *
 * @public
 * @returns {Boolean}
 */
Item.prototype.isDestroyed = function () {
  return this._isDestroyed;
};

/**
 * Private prototype methods
 * *************************
 */

/**
 * Recalculate item's dimensions.
 *
 * @private
 * @param {Boolean} [force=false]
 */
Item.prototype._refreshDimensions = function (force) {
  if (this._isDestroyed) return;
  if (force !== true && this._visibility._isHidden) return;

  var element = this._element;
  var dragPlaceholder = this._dragPlaceholder;
  var rect = element.getBoundingClientRect();

  // Calculate width and height.
  this._width = rect.width;
  this._height = rect.height;

  // Calculate margins (ignore negative margins).
  this._marginLeft = Math.max(0, getStyleAsFloat(element, 'margin-left'));
  this._marginRight = Math.max(0, getStyleAsFloat(element, 'margin-right'));
  this._marginTop = Math.max(0, getStyleAsFloat(element, 'margin-top'));
  this._marginBottom = Math.max(0, getStyleAsFloat(element, 'margin-bottom'));

  // Keep drag placeholder's dimensions synced with the item's.
  if (dragPlaceholder) dragPlaceholder.updateDimensions();
};

/**
 * Fetch and store item's sort data.
 *
 * @private
 */
Item.prototype._refreshSortData = function () {
  if (this._isDestroyed) return;

  var data = (this._sortData = {});
  var getters = this.getGrid()._settings.sortData;
  var prop;

  for (prop in getters) {
    data[prop] = getters[prop](this, this._element);
  }
};

/**
 * Add item to layout.
 *
 * @private
 */
Item.prototype._addToLayout = function (left, top) {
  if (this._isActive === true) return;
  this._isActive = true;
  this._left = left || 0;
  this._top = top || 0;
};

/**
 * Remove item from layout.
 *
 * @private
 */
Item.prototype._removeFromLayout = function () {
  if (this._isActive === false) return;
  this._isActive = false;
  this._left = 0;
  this._top = 0;
};

/**
 * Check if the layout procedure can be skipped for the item.
 *
 * @private
 * @param {Number} left
 * @param {Number} top
 * @returns {Boolean}
 */
Item.prototype._canSkipLayout = function (left, top) {
  return (
    this._left === left &&
    this._top === top &&
    !this._migrate._isActive &&
    !this._layout._skipNextAnimation &&
    !this._dragRelease.isJustReleased()
  );
};

/**
 * Set the provided left and top arguments as the item element's translate
 * values in the DOM. This method keeps track of the currently applied
 * translate values and skips the update operation if the provided values are
 * identical to the currently applied values. Returns `false` if there was no
 * need for update and `true` if the translate value was updated.
 *
 * @private
 * @param {Number} left
 * @param {Number} top
 * @returns {Boolean}
 */
Item.prototype._setTranslate = function (left, top) {
  if (this._tX === left && this._tY === top) return false;
  this._tX = left;
  this._tY = top;
  this._element.style[transformProp] = getTranslateString(left, top);
  return true;
};

/**
 * Destroy item instance.
 *
 * @private
 * @param {Boolean} [removeElement=false]
 */
Item.prototype._destroy = function (removeElement) {
  if (this._isDestroyed) return;

  var element = this._element;
  var grid = this.getGrid();
  var settings = grid._settings;

  // Destroy handlers.
  this._dragPlaceholder.destroy();
  this._dragRelease.destroy();
  this._migrate.destroy();
  this._layout.destroy();
  this._visibility.destroy();
  if (this._drag) this._drag.destroy();

  // Destroy emitter.
  this._emitter.destroy();

  // Remove item class.
  removeClass(element, settings.itemClass);

  // Remove element from DOM.
  if (removeElement) element.parentNode.removeChild(element);

  // Remove item/element pair from map.
  if (ITEM_ELEMENT_MAP) ITEM_ELEMENT_MAP.delete(element);

  // Reset state.
  this._isActive = false;
  this._isDestroyed = true;
};

function createPackerProcessor(isWorker) {
  var FILL_GAPS = 1;
  var HORIZONTAL = 2;
  var ALIGN_RIGHT = 4;
  var ALIGN_BOTTOM = 8;
  var ROUNDING = 16;

  var EPS = 0.001;
  var MIN_SLOT_SIZE = 0.5;

  // Rounds number first to three decimal precision and then floors the result
  // to two decimal precision.
  // Math.floor(Math.round(number * 1000) / 10) / 100
  function roundNumber(number) {
    return ((((number * 1000 + 0.5) << 0) / 10) << 0) / 100;
  }

  /**
   * @class
   */
  function PackerProcessor() {
    this.currentRects = [];
    this.nextRects = [];
    this.rectTarget = {};
    this.rectStore = [];
    this.slotSizes = [];
    this.rectId = 0;
    this.slotIndex = -1;
    this.slotData = { left: 0, top: 0, width: 0, height: 0 };
    this.sortRectsLeftTop = this.sortRectsLeftTop.bind(this);
    this.sortRectsTopLeft = this.sortRectsTopLeft.bind(this);
  }

  /**
   * Takes a layout object as an argument and computes positions (slots) for the
   * layout items. Also computes the final width and height of the layout. The
   * provided layout object's slots array is mutated as well as the width and
   * height properties.
   *
   * @param {Object} layout
   * @param {Number} layout.width
   *   - The start (current) width of the layout in pixels.
   * @param {Number} layout.height
   *   - The start (current) height of the layout in pixels.
   * @param {(Item[]|Number[])} layout.items
   *   - List of Muuri.Item instances or a list of item dimensions
   *     (e.g [ item1Width, item1Height, item2Width, item2Height, ... ]).
   * @param {(Array|Float32Array)} layout.slots
   *   - An Array/Float32Array instance which's length should equal to
   *     the amount of items times two. The position (width and height) of each
   *     item will be written into this array.
   * @param {Number} settings
   *   - The layout's settings as bitmasks.
   * @returns {Object}
   */
  PackerProcessor.prototype.computeLayout = function (layout, settings) {
    var items = layout.items;
    var slots = layout.slots;
    var fillGaps = !!(settings & FILL_GAPS);
    var horizontal = !!(settings & HORIZONTAL);
    var alignRight = !!(settings & ALIGN_RIGHT);
    var alignBottom = !!(settings & ALIGN_BOTTOM);
    var rounding = !!(settings & ROUNDING);
    var isPreProcessed = typeof items[0] === 'number';
    var i, bump, item, slotWidth, slotHeight, slot;

    // No need to go further if items do not exist.
    if (!items.length) return layout;

    // Compute slots for the items.
    bump = isPreProcessed ? 2 : 1;
    for (i = 0; i < items.length; i += bump) {
      // If items are pre-processed it means that items array contains only
      // the raw dimensions of the items. Otherwise we assume it is an array
      // of normal Muuri items.
      if (isPreProcessed) {
        slotWidth = items[i];
        slotHeight = items[i + 1];
      } else {
        item = items[i];
        slotWidth = item._width + item._marginLeft + item._marginRight;
        slotHeight = item._height + item._marginTop + item._marginBottom;
      }

      // If rounding is enabled let's round the item's width and height to
      // make the layout algorithm a bit more stable. This has a performance
      // cost so don't use this if not necessary.
      if (rounding) {
        slotWidth = roundNumber(slotWidth);
        slotHeight = roundNumber(slotHeight);
      }

      // Get slot data.
      slot = this.computeNextSlot(layout, slotWidth, slotHeight, fillGaps, horizontal);

      // Update layout width/height.
      if (horizontal) {
        if (slot.left + slot.width > layout.width) {
          layout.width = slot.left + slot.width;
        }
      } else {
        if (slot.top + slot.height > layout.height) {
          layout.height = slot.top + slot.height;
        }
      }

      // Add item slot data to layout slots.
      slots[++this.slotIndex] = slot.left;
      slots[++this.slotIndex] = slot.top;

      // Store the size too (for later usage) if needed.
      if (alignRight || alignBottom) {
        this.slotSizes.push(slot.width, slot.height);
      }
    }

    // If the alignment is set to right we need to adjust the results.
    if (alignRight) {
      for (i = 0; i < slots.length; i += 2) {
        slots[i] = layout.width - (slots[i] + this.slotSizes[i]);
      }
    }

    // If the alignment is set to bottom we need to adjust the results.
    if (alignBottom) {
      for (i = 1; i < slots.length; i += 2) {
        slots[i] = layout.height - (slots[i] + this.slotSizes[i]);
      }
    }

    // Reset stuff.
    this.slotSizes.length = 0;
    this.currentRects.length = 0;
    this.nextRects.length = 0;
    this.rectStore.length = 0;
    this.rectId = 0;
    this.slotIndex = -1;

    return layout;
  };

  /**
   * Calculate next slot in the layout. Returns a slot object with position and
   * dimensions data. The returned object is reused between calls.
   *
   * @param {Object} layout
   * @param {Number} slotWidth
   * @param {Number} slotHeight
   * @param {Boolean} fillGaps
   * @param {Boolean} horizontal
   * @returns {Object}
   */
  PackerProcessor.prototype.computeNextSlot = function (
    layout,
    slotWidth,
    slotHeight,
    fillGaps,
    horizontal
  ) {
    var slot = this.slotData;
    var currentRects = this.currentRects;
    var nextRects = this.nextRects;
    var ignoreCurrentRects = false;
    var rect;
    var rectId;
    var shards;
    var i;
    var j;

    // Reset new slots.
    nextRects.length = 0;

    // Set item slot initial data.
    slot.left = null;
    slot.top = null;
    slot.width = slotWidth;
    slot.height = slotHeight;

    // Try to find position for the slot from the existing free spaces in the
    // layout.
    for (i = 0; i < currentRects.length; i++) {
      rectId = currentRects[i];
      if (!rectId) continue;
      rect = this.getRect(rectId);
      if (slot.width <= rect.width + EPS && slot.height <= rect.height + EPS) {
        slot.left = rect.left;
        slot.top = rect.top;
        break;
      }
    }

    // If no position was found for the slot let's position the slot to
    // the bottom left (in vertical mode) or top right (in horizontal mode) of
    // the layout.
    if (slot.left === null) {
      if (horizontal) {
        slot.left = layout.width;
        slot.top = 0;
      } else {
        slot.left = 0;
        slot.top = layout.height;
      }

      // If gaps don't need filling let's throw away all the current free spaces
      // (currentRects).
      if (!fillGaps) {
        ignoreCurrentRects = true;
      }
    }

    // In vertical mode, if the slot's bottom overlaps the layout's bottom.
    if (!horizontal && slot.top + slot.height > layout.height + EPS) {
      // If slot is not aligned to the left edge, create a new free space to the
      // left of the slot.
      if (slot.left > MIN_SLOT_SIZE) {
        nextRects.push(this.addRect(0, layout.height, slot.left, Infinity));
      }

      // If slot is not aligned to the right edge, create a new free space to
      // the right of the slot.
      if (slot.left + slot.width < layout.width - MIN_SLOT_SIZE) {
        nextRects.push(
          this.addRect(
            slot.left + slot.width,
            layout.height,
            layout.width - slot.left - slot.width,
            Infinity
          )
        );
      }

      // Update layout height.
      layout.height = slot.top + slot.height;
    }

    // In horizontal mode, if the slot's right overlaps the layout's right edge.
    if (horizontal && slot.left + slot.width > layout.width + EPS) {
      // If slot is not aligned to the top, create a new free space above the
      // slot.
      if (slot.top > MIN_SLOT_SIZE) {
        nextRects.push(this.addRect(layout.width, 0, Infinity, slot.top));
      }

      // If slot is not aligned to the bottom, create a new free space below
      // the slot.
      if (slot.top + slot.height < layout.height - MIN_SLOT_SIZE) {
        nextRects.push(
          this.addRect(
            layout.width,
            slot.top + slot.height,
            Infinity,
            layout.height - slot.top - slot.height
          )
        );
      }

      // Update layout width.
      layout.width = slot.left + slot.width;
    }

    // Clean up the current free spaces making sure none of them overlap with
    // the slot. Split all overlapping free spaces into smaller shards that do
    // not overlap with the slot.
    if (!ignoreCurrentRects) {
      if (fillGaps) i = 0;
      for (; i < currentRects.length; i++) {
        rectId = currentRects[i];
        if (!rectId) continue;
        rect = this.getRect(rectId);
        shards = this.splitRect(rect, slot);
        for (j = 0; j < shards.length; j++) {
          rectId = shards[j];
          rect = this.getRect(rectId);
          // Make sure that the free space is within the boundaries of the
          // layout. This routine is critical to the algorithm as it makes sure
          // that there are no leftover spaces with infinite height/width.
          // It's also essential that we don't compare values absolutely to each
          // other but leave a little headroom (EPSILON) to get rid of false
          // positives.
          if (
            horizontal ? rect.left + EPS < layout.width - EPS : rect.top + EPS < layout.height - EPS
          ) {
            nextRects.push(rectId);
          }
        }
      }
    }

    // Sanitize and sort all the new free spaces that will be used in the next
    // iteration. This procedure is critical to make the bin-packing algorithm
    // work. The free spaces have to be in correct order in the beginning of the
    // next iteration.
    if (nextRects.length > 1) {
      this.purgeRects(nextRects).sort(horizontal ? this.sortRectsLeftTop : this.sortRectsTopLeft);
    }

    // Finally we need to make sure that `this.currentRects` points to
    // `nextRects` array as that is used in the next iteration's beginning when
    // we try to find a space for the next slot.
    this.currentRects = nextRects;
    this.nextRects = currentRects;

    return slot;
  };

  /**
   * Add a new rectangle to the rectangle store. Returns the id of the new
   * rectangle.
   *
   * @param {Number} left
   * @param {Number} top
   * @param {Number} width
   * @param {Number} height
   * @returns {Number}
   */
  PackerProcessor.prototype.addRect = function (left, top, width, height) {
    var rectId = ++this.rectId;
    this.rectStore[rectId] = left || 0;
    this.rectStore[++this.rectId] = top || 0;
    this.rectStore[++this.rectId] = width || 0;
    this.rectStore[++this.rectId] = height || 0;
    return rectId;
  };

  /**
   * Get rectangle data from the rectangle store by id. Optionally you can
   * provide a target object where the rectangle data will be written in. By
   * default an internal object is reused as a target object.
   *
   * @param {Number} id
   * @param {Object} [target]
   * @returns {Object}
   */
  PackerProcessor.prototype.getRect = function (id, target) {
    if (!target) target = this.rectTarget;
    target.left = this.rectStore[id] || 0;
    target.top = this.rectStore[++id] || 0;
    target.width = this.rectStore[++id] || 0;
    target.height = this.rectStore[++id] || 0;
    return target;
  };

  /**
   * Punch a hole into a rectangle and return the shards (1-4).
   *
   * @param {Object} rect
   * @param {Object} hole
   * @returns {Number[]}
   */
  PackerProcessor.prototype.splitRect = (function () {
    var shards = [];
    var width = 0;
    var height = 0;
    return function (rect, hole) {
      // Reset old shards.
      shards.length = 0;

      // If the slot does not overlap with the hole add slot to the return data
      // as is. Note that in this case we are eager to keep the slot as is if
      // possible so we use the EPSILON in favour of that logic.
      if (
        rect.left + rect.width <= hole.left + EPS ||
        hole.left + hole.width <= rect.left + EPS ||
        rect.top + rect.height <= hole.top + EPS ||
        hole.top + hole.height <= rect.top + EPS
      ) {
        shards.push(this.addRect(rect.left, rect.top, rect.width, rect.height));
        return shards;
      }

      // Left split.
      width = hole.left - rect.left;
      if (width >= MIN_SLOT_SIZE) {
        shards.push(this.addRect(rect.left, rect.top, width, rect.height));
      }

      // Right split.
      width = rect.left + rect.width - (hole.left + hole.width);
      if (width >= MIN_SLOT_SIZE) {
        shards.push(this.addRect(hole.left + hole.width, rect.top, width, rect.height));
      }

      // Top split.
      height = hole.top - rect.top;
      if (height >= MIN_SLOT_SIZE) {
        shards.push(this.addRect(rect.left, rect.top, rect.width, height));
      }

      // Bottom split.
      height = rect.top + rect.height - (hole.top + hole.height);
      if (height >= MIN_SLOT_SIZE) {
        shards.push(this.addRect(rect.left, hole.top + hole.height, rect.width, height));
      }

      return shards;
    };
  })();

  /**
   * Check if a rectangle is fully within another rectangle.
   *
   * @param {Object} a
   * @param {Object} b
   * @returns {Boolean}
   */
  PackerProcessor.prototype.isRectAWithinRectB = function (a, b) {
    return (
      a.left + EPS >= b.left &&
      a.top + EPS >= b.top &&
      a.left + a.width - EPS <= b.left + b.width &&
      a.top + a.height - EPS <= b.top + b.height
    );
  };

  /**
   * Loops through an array of rectangle ids and resets all that are fully
   * within another rectangle in the array. Resetting in this case means that
   * the rectangle id value is replaced with zero.
   *
   * @param {Number[]} rectIds
   * @returns {Number[]}
   */
  PackerProcessor.prototype.purgeRects = (function () {
    var rectA = {};
    var rectB = {};
    return function (rectIds) {
      var i = rectIds.length;
      var j;

      while (i--) {
        j = rectIds.length;
        if (!rectIds[i]) continue;
        this.getRect(rectIds[i], rectA);
        while (j--) {
          if (!rectIds[j] || i === j) continue;
          this.getRect(rectIds[j], rectB);
          if (this.isRectAWithinRectB(rectA, rectB)) {
            rectIds[i] = 0;
            break;
          }
        }
      }

      return rectIds;
    };
  })();

  /**
   * Sort rectangles with top-left gravity.
   *
   * @param {Number} aId
   * @param {Number} bId
   * @returns {Number}
   */
  PackerProcessor.prototype.sortRectsTopLeft = (function () {
    var rectA = {};
    var rectB = {};
    return function (aId, bId) {
      this.getRect(aId, rectA);
      this.getRect(bId, rectB);

      return rectA.top < rectB.top && rectA.top + EPS < rectB.top
        ? -1
        : rectA.top > rectB.top && rectA.top - EPS > rectB.top
        ? 1
        : rectA.left < rectB.left && rectA.left + EPS < rectB.left
        ? -1
        : rectA.left > rectB.left && rectA.left - EPS > rectB.left
        ? 1
        : 0;
    };
  })();

  /**
   * Sort rectangles with left-top gravity.
   *
   * @param {Number} aId
   * @param {Number} bId
   * @returns {Number}
   */
  PackerProcessor.prototype.sortRectsLeftTop = (function () {
    var rectA = {};
    var rectB = {};
    return function (aId, bId) {
      this.getRect(aId, rectA);
      this.getRect(bId, rectB);
      return rectA.left < rectB.left && rectA.left + EPS < rectB.left
        ? -1
        : rectA.left > rectB.left && rectA.left - EPS < rectB.left
        ? 1
        : rectA.top < rectB.top && rectA.top + EPS < rectB.top
        ? -1
        : rectA.top > rectB.top && rectA.top - EPS > rectB.top
        ? 1
        : 0;
    };
  })();

  if (isWorker) {
    var PACKET_INDEX_WIDTH = 1;
    var PACKET_INDEX_HEIGHT = 2;
    var PACKET_INDEX_OPTIONS = 3;
    var PACKET_HEADER_SLOTS = 4;
    var processor = new PackerProcessor();

    self.onmessage = function (msg) {
      var data = new Float32Array(msg.data);
      var items = data.subarray(PACKET_HEADER_SLOTS, data.length);
      var slots = new Float32Array(items.length);
      var settings = data[PACKET_INDEX_OPTIONS];
      var layout = {
        items: items,
        slots: slots,
        width: data[PACKET_INDEX_WIDTH],
        height: data[PACKET_INDEX_HEIGHT],
      };

      // Compute the layout (width / height / slots).
      processor.computeLayout(layout, settings);

      // Copy layout data to the return data.
      data[PACKET_INDEX_WIDTH] = layout.width;
      data[PACKET_INDEX_HEIGHT] = layout.height;
      data.set(layout.slots, PACKET_HEADER_SLOTS);

      // Send layout back to the main thread.
      postMessage(data.buffer, [data.buffer]);
    };
  }

  return PackerProcessor;
}

var PackerProcessor = createPackerProcessor();

//
// WORKER UTILS
//

var blobUrl = null;
var activeWorkers = [];

function createWorkerProcessors(amount, onmessage) {
  var workers = [];

  if (amount > 0) {
    if (!blobUrl) {
      blobUrl = URL.createObjectURL(
        new Blob(['(' + createPackerProcessor.toString() + ')(true)'], {
          type: 'application/javascript',
        })
      );
    }

    for (var i = 0, worker; i < amount; i++) {
      worker = new Worker(blobUrl);
      if (onmessage) worker.onmessage = onmessage;
      workers.push(worker);
      activeWorkers.push(worker);
    }
  }

  return workers;
}

function destroyWorkerProcessors(workers) {
  var worker;
  var index;

  for (var i = 0; i < workers.length; i++) {
    worker = workers[i];
    worker.onmessage = null;
    worker.onerror = null;
    worker.onmessageerror = null;
    worker.terminate();

    index = activeWorkers.indexOf(worker);
    if (index > -1) activeWorkers.splice(index, 1);
  }

  if (blobUrl && !activeWorkers.length) {
    URL.revokeObjectURL(blobUrl);
    blobUrl = null;
  }
}

function isWorkerProcessorsSupported() {
  return !!(window.Worker && window.URL && window.Blob);
}

var FILL_GAPS = 1;
var HORIZONTAL = 2;
var ALIGN_RIGHT = 4;
var ALIGN_BOTTOM = 8;
var ROUNDING = 16;
var PACKET_INDEX_ID = 0;
var PACKET_INDEX_WIDTH = 1;
var PACKET_INDEX_HEIGHT = 2;
var PACKET_INDEX_OPTIONS = 3;
var PACKET_HEADER_SLOTS = 4;

/**
 * @class
 * @param {Number} [numWorkers=0]
 * @param {Object} [options]
 * @param {Boolean} [options.fillGaps=false]
 * @param {Boolean} [options.horizontal=false]
 * @param {Boolean} [options.alignRight=false]
 * @param {Boolean} [options.alignBottom=false]
 * @param {Boolean} [options.rounding=false]
 */
function Packer(numWorkers, options) {
  this._options = 0;
  this._processor = null;
  this._layoutQueue = [];
  this._layouts = {};
  this._layoutCallbacks = {};
  this._layoutWorkers = {};
  this._layoutWorkerData = {};
  this._workers = [];
  this._onWorkerMessage = this._onWorkerMessage.bind(this);

  // Set initial options.
  this.setOptions(options);

  // Init the worker(s) or the processor if workers can't be used.
  numWorkers = typeof numWorkers === 'number' ? Math.max(0, numWorkers) : 0;
  if (numWorkers && isWorkerProcessorsSupported()) {
    try {
      this._workers = createWorkerProcessors(numWorkers, this._onWorkerMessage);
    } catch (e) {
      this._processor = new PackerProcessor();
    }
  } else {
    this._processor = new PackerProcessor();
  }
}

Packer.prototype._sendToWorker = function () {
  if (!this._layoutQueue.length || !this._workers.length) return;

  var layoutId = this._layoutQueue.shift();
  var worker = this._workers.pop();
  var data = this._layoutWorkerData[layoutId];

  delete this._layoutWorkerData[layoutId];
  this._layoutWorkers[layoutId] = worker;
  worker.postMessage(data.buffer, [data.buffer]);
};

Packer.prototype._onWorkerMessage = function (msg) {
  var data = new Float32Array(msg.data);
  var layoutId = data[PACKET_INDEX_ID];
  var layout = this._layouts[layoutId];
  var callback = this._layoutCallbacks[layoutId];
  var worker = this._layoutWorkers[layoutId];

  if (layout) delete this._layouts[layoutId];
  if (callback) delete this._layoutCallbacks[layoutId];
  if (worker) delete this._layoutWorkers[layoutId];

  if (layout && callback) {
    layout.width = data[PACKET_INDEX_WIDTH];
    layout.height = data[PACKET_INDEX_HEIGHT];
    layout.slots = data.subarray(PACKET_HEADER_SLOTS, data.length);
    this._finalizeLayout(layout);
    callback(layout);
  }

  if (worker) {
    this._workers.push(worker);
    this._sendToWorker();
  }
};

Packer.prototype._finalizeLayout = function (layout) {
  var grid = layout._grid;
  var isHorizontal = layout._settings & HORIZONTAL;
  var isBorderBox = grid._boxSizing === 'border-box';

  delete layout._grid;
  delete layout._settings;

  layout.styles = {};

  if (isHorizontal) {
    layout.styles.width =
      (isBorderBox ? layout.width + grid._borderLeft + grid._borderRight : layout.width) + 'px';
  } else {
    layout.styles.height =
      (isBorderBox ? layout.height + grid._borderTop + grid._borderBottom : layout.height) + 'px';
  }

  return layout;
};

/**
 * @public
 * @param {Object} [options]
 * @param {Boolean} [options.fillGaps]
 * @param {Boolean} [options.horizontal]
 * @param {Boolean} [options.alignRight]
 * @param {Boolean} [options.alignBottom]
 * @param {Boolean} [options.rounding]
 */
Packer.prototype.setOptions = function (options) {
  if (!options) return;

  var fillGaps;
  if (typeof options.fillGaps === 'boolean') {
    fillGaps = options.fillGaps ? FILL_GAPS : 0;
  } else {
    fillGaps = this._options & FILL_GAPS;
  }

  var horizontal;
  if (typeof options.horizontal === 'boolean') {
    horizontal = options.horizontal ? HORIZONTAL : 0;
  } else {
    horizontal = this._options & HORIZONTAL;
  }

  var alignRight;
  if (typeof options.alignRight === 'boolean') {
    alignRight = options.alignRight ? ALIGN_RIGHT : 0;
  } else {
    alignRight = this._options & ALIGN_RIGHT;
  }

  var alignBottom;
  if (typeof options.alignBottom === 'boolean') {
    alignBottom = options.alignBottom ? ALIGN_BOTTOM : 0;
  } else {
    alignBottom = this._options & ALIGN_BOTTOM;
  }

  var rounding;
  if (typeof options.rounding === 'boolean') {
    rounding = options.rounding ? ROUNDING : 0;
  } else {
    rounding = this._options & ROUNDING;
  }

  this._options = fillGaps | horizontal | alignRight | alignBottom | rounding;
};

/**
 * @public
 * @param {Grid} grid
 * @param {Number} layoutId
 * @param {Item[]} items
 * @param {Number} width
 * @param {Number} height
 * @param {Function} callback
 * @returns {?Function}
 */
Packer.prototype.createLayout = function (grid, layoutId, items, width, height, callback) {
  if (this._layouts[layoutId]) {
    throw new Error('A layout with the provided id is currently being processed.');
  }

  var horizontal = this._options & HORIZONTAL;
  var layout = {
    id: layoutId,
    items: items,
    slots: null,
    width: horizontal ? 0 : width,
    height: !horizontal ? 0 : height,
    // Temporary data, which will be removed before sending the layout data
    // outside of Packer's context.
    _grid: grid,
    _settings: this._options,
  };

  // If there are no items let's call the callback immediately.
  if (!items.length) {
    layout.slots = [];
    this._finalizeLayout(layout);
    callback(layout);
    return;
  }

  // Create layout synchronously if needed.
  if (this._processor) {
    layout.slots = window.Float32Array
      ? new Float32Array(items.length * 2)
      : new Array(items.length * 2);
    this._processor.computeLayout(layout, layout._settings);
    this._finalizeLayout(layout);
    callback(layout);
    return;
  }

  // Worker data.
  var data = new Float32Array(PACKET_HEADER_SLOTS + items.length * 2);

  // Worker data header.
  data[PACKET_INDEX_ID] = layoutId;
  data[PACKET_INDEX_WIDTH] = layout.width;
  data[PACKET_INDEX_HEIGHT] = layout.height;
  data[PACKET_INDEX_OPTIONS] = layout._settings;

  // Worker data items.
  var i, j, item;
  for (i = 0, j = PACKET_HEADER_SLOTS - 1, item; i < items.length; i++) {
    item = items[i];
    data[++j] = item._width + item._marginLeft + item._marginRight;
    data[++j] = item._height + item._marginTop + item._marginBottom;
  }

  this._layoutQueue.push(layoutId);
  this._layouts[layoutId] = layout;
  this._layoutCallbacks[layoutId] = callback;
  this._layoutWorkerData[layoutId] = data;

  this._sendToWorker();

  return this.cancelLayout.bind(this, layoutId);
};

/**
 * @public
 * @param {Number} layoutId
 */
Packer.prototype.cancelLayout = function (layoutId) {
  var layout = this._layouts[layoutId];
  if (!layout) return;

  delete this._layouts[layoutId];
  delete this._layoutCallbacks[layoutId];

  if (this._layoutWorkerData[layoutId]) {
    delete this._layoutWorkerData[layoutId];
    var queueIndex = this._layoutQueue.indexOf(layoutId);
    if (queueIndex > -1) this._layoutQueue.splice(queueIndex, 1);
  }
};

/**
 * @public
 */
Packer.prototype.destroy = function () {
  // Move all currently used workers back in the workers array.
  for (var key in this._layoutWorkers) {
    this._workers.push(this._layoutWorkers[key]);
  }

  // Destroy all instance's workers.
  destroyWorkerProcessors(this._workers);

  // Reset data.
  this._workers.length = 0;
  this._layoutQueue.length = 0;
  this._layouts = {};
  this._layoutCallbacks = {};
  this._layoutWorkers = {};
  this._layoutWorkerData = {};
};

var debounceId = 0;

/**
 * Returns a function, that, as long as it continues to be invoked, will not
 * be triggered. The function will be called after it stops being called for
 * N milliseconds. The returned function accepts one argument which, when
 * being `true`, cancels the debounce function immediately. When the debounce
 * function is canceled it cannot be invoked again.
 *
 * @param {Function} fn
 * @param {Number} durationMs
 * @returns {Function}
 */
function debounce(fn, durationMs) {
  var id = ++debounceId;
  var timer = 0;
  var lastTime = 0;
  var isCanceled = false;
  var tick = function (time) {
    if (isCanceled) return;

    if (lastTime) timer -= time - lastTime;
    lastTime = time;

    if (timer > 0) {
      addDebounceTick(id, tick);
    } else {
      timer = lastTime = 0;
      fn();
    }
  };

  return function (cancel) {
    if (isCanceled) return;

    if (durationMs <= 0) {
      if (cancel !== true) fn();
      return;
    }

    if (cancel === true) {
      isCanceled = true;
      timer = lastTime = 0;
      tick = undefined;
      cancelDebounceTick(id);
      return;
    }

    if (timer <= 0) {
      timer = durationMs;
      tick(0);
    } else {
      timer = durationMs;
    }
  };
}

var htmlCollectionType = '[object HTMLCollection]';
var nodeListType = '[object NodeList]';

/**
 * Check if a value is a node list or a html collection.
 *
 * @param {*} val
 * @returns {Boolean}
 */
function isNodeList(val) {
  var type = Object.prototype.toString.call(val);
  return type === htmlCollectionType || type === nodeListType;
}

var objectType = 'object';
var objectToStringType = '[object Object]';
var toString = Object.prototype.toString;

/**
 * Check if a value is a plain object.
 *
 * @param {*} val
 * @returns {Boolean}
 */
function isPlainObject(val) {
  return typeof val === objectType && toString.call(val) === objectToStringType;
}

function noop() {}

/**
 * Converts a value to an array or clones an array.
 *
 * @param {*} val
 * @returns {Array}
 */
function toArray(val) {
  return isNodeList(val) ? Array.prototype.slice.call(val) : Array.prototype.concat(val);
}

var NUMBER_TYPE = 'number';
var STRING_TYPE = 'string';
var INSTANT_LAYOUT = 'instant';
var layoutId = 0;

/**
 * Creates a new Grid instance.
 *
 * @class
 * @param {(HTMLElement|String)} element
 * @param {Object} [options]
 * @param {(String|HTMLElement[]|NodeList|HTMLCollection)} [options.items="*"]
 * @param {Number} [options.showDuration=300]
 * @param {String} [options.showEasing="ease"]
 * @param {Object} [options.visibleStyles={opacity: "1", transform: "scale(1)"}]
 * @param {Number} [options.hideDuration=300]
 * @param {String} [options.hideEasing="ease"]
 * @param {Object} [options.hiddenStyles={opacity: "0", transform: "scale(0.5)"}]
 * @param {(Function|Object)} [options.layout]
 * @param {Boolean} [options.layout.fillGaps=false]
 * @param {Boolean} [options.layout.horizontal=false]
 * @param {Boolean} [options.layout.alignRight=false]
 * @param {Boolean} [options.layout.alignBottom=false]
 * @param {Boolean} [options.layout.rounding=false]
 * @param {(Boolean|Number)} [options.layoutOnResize=150]
 * @param {Boolean} [options.layoutOnInit=true]
 * @param {Number} [options.layoutDuration=300]
 * @param {String} [options.layoutEasing="ease"]
 * @param {?Object} [options.sortData=null]
 * @param {Boolean} [options.dragEnabled=false]
 * @param {?String} [options.dragHandle=null]
 * @param {?HtmlElement} [options.dragContainer=null]
 * @param {?Function} [options.dragStartPredicate]
 * @param {Number} [options.dragStartPredicate.distance=0]
 * @param {Number} [options.dragStartPredicate.delay=0]
 * @param {String} [options.dragAxis="xy"]
 * @param {(Boolean|Function)} [options.dragSort=true]
 * @param {Object} [options.dragSortHeuristics]
 * @param {Number} [options.dragSortHeuristics.sortInterval=100]
 * @param {Number} [options.dragSortHeuristics.minDragDistance=10]
 * @param {Number} [options.dragSortHeuristics.minBounceBackAngle=1]
 * @param {(Function|Object)} [options.dragSortPredicate]
 * @param {Number} [options.dragSortPredicate.threshold=50]
 * @param {String} [options.dragSortPredicate.action="move"]
 * @param {String} [options.dragSortPredicate.migrateAction="move"]
 * @param {Object} [options.dragRelease]
 * @param {Number} [options.dragRelease.duration=300]
 * @param {String} [options.dragRelease.easing="ease"]
 * @param {Boolean} [options.dragRelease.useDragContainer=true]
 * @param {Object} [options.dragCssProps]
 * @param {Object} [options.dragPlaceholder]
 * @param {Boolean} [options.dragPlaceholder.enabled=false]
 * @param {?Function} [options.dragPlaceholder.createElement=null]
 * @param {?Function} [options.dragPlaceholder.onCreate=null]
 * @param {?Function} [options.dragPlaceholder.onRemove=null]
 * @param {Object} [options.dragAutoScroll]
 * @param {(Function|Array)} [options.dragAutoScroll.targets=[]]
 * @param {?Function} [options.dragAutoScroll.handle=null]
 * @param {Number} [options.dragAutoScroll.threshold=50]
 * @param {Number} [options.dragAutoScroll.safeZone=0.2]
 * @param {(Function|Number)} [options.dragAutoScroll.speed]
 * @param {Boolean} [options.dragAutoScroll.sortDuringScroll=true]
 * @param {Boolean} [options.dragAutoScroll.smoothStop=false]
 * @param {?Function} [options.dragAutoScroll.onStart=null]
 * @param {?Function} [options.dragAutoScroll.onStop=null]
 * @param {String} [options.containerClass="muuri"]
 * @param {String} [options.itemClass="muuri-item"]
 * @param {String} [options.itemVisibleClass="muuri-item-visible"]
 * @param {String} [options.itemHiddenClass="muuri-item-hidden"]
 * @param {String} [options.itemPositioningClass="muuri-item-positioning"]
 * @param {String} [options.itemDraggingClass="muuri-item-dragging"]
 * @param {String} [options.itemReleasingClass="muuri-item-releasing"]
 * @param {String} [options.itemPlaceholderClass="muuri-item-placeholder"]
 */
function Grid(element, options) {
  // Allow passing element as selector string
  if (typeof element === STRING_TYPE) {
    element = document.querySelector(element);
  }

  // Throw an error if the container element is not body element or does not
  // exist within the body element.
  var isElementInDom = element.getRootNode
    ? element.getRootNode({ composed: true }) === document
    : document.body.contains(element);
  if (!isElementInDom || element === document.documentElement) {
    throw new Error('Container element must be an existing DOM element.');
  }

  // Create instance settings by merging the options with default options.
  var settings = mergeSettings(Grid.defaultOptions, options);
  settings.visibleStyles = normalizeStyles(settings.visibleStyles);
  settings.hiddenStyles = normalizeStyles(settings.hiddenStyles);
  if (!isFunction(settings.dragSort)) {
    settings.dragSort = !!settings.dragSort;
  }

  this._id = createUid();
  this._element = element;
  this._settings = settings;
  this._isDestroyed = false;
  this._items = [];
  this._layout = {
    id: 0,
    items: [],
    slots: [],
  };
  this._isLayoutFinished = true;
  this._nextLayoutData = null;
  this._emitter = new Emitter();
  this._onLayoutDataReceived = this._onLayoutDataReceived.bind(this);

  // Store grid instance to the grid instances collection.
  GRID_INSTANCES[this._id] = this;

  // Add container element's class name.
  addClass(element, settings.containerClass);

  // If layoutOnResize option is a valid number sanitize it and bind the resize
  // handler.
  bindLayoutOnResize(this, settings.layoutOnResize);

  // Add initial items.
  this.add(getInitialGridElements(element, settings.items), { layout: false });

  // Layout on init if necessary.
  if (settings.layoutOnInit) {
    this.layout(true);
  }
}

/**
 * Public properties
 * *****************
 */

/**
 * @public
 * @static
 * @see Item
 */
Grid.Item = Item;

/**
 * @public
 * @static
 * @see ItemLayout
 */
Grid.ItemLayout = ItemLayout;

/**
 * @public
 * @static
 * @see ItemVisibility
 */
Grid.ItemVisibility = ItemVisibility;

/**
 * @public
 * @static
 * @see ItemMigrate
 */
Grid.ItemMigrate = ItemMigrate;

/**
 * @public
 * @static
 * @see ItemDrag
 */
Grid.ItemDrag = ItemDrag;

/**
 * @public
 * @static
 * @see ItemDragRelease
 */
Grid.ItemDragRelease = ItemDragRelease;

/**
 * @public
 * @static
 * @see ItemDragPlaceholder
 */
Grid.ItemDragPlaceholder = ItemDragPlaceholder;

/**
 * @public
 * @static
 * @see Emitter
 */
Grid.Emitter = Emitter;

/**
 * @public
 * @static
 * @see Animator
 */
Grid.Animator = Animator;

/**
 * @public
 * @static
 * @see Dragger
 */
Grid.Dragger = Dragger;

/**
 * @public
 * @static
 * @see Packer
 */
Grid.Packer = Packer;

/**
 * @public
 * @static
 * @see AutoScroller
 */
Grid.AutoScroller = AutoScroller;

/**
 * The default Packer instance used by default for all layouts.
 *
 * @public
 * @static
 * @type {Packer}
 */
Grid.defaultPacker = new Packer(2);

/**
 * Default options for Grid instance.
 *
 * @public
 * @static
 * @type {Object}
 */
Grid.defaultOptions = {
  // Initial item elements
  items: '*',

  // Default show animation
  showDuration: 300,
  showEasing: 'ease',

  // Default hide animation
  hideDuration: 300,
  hideEasing: 'ease',

  // Item's visible/hidden state styles
  visibleStyles: {
    opacity: '1',
    transform: 'scale(1)',
  },
  hiddenStyles: {
    opacity: '0',
    transform: 'scale(0.5)',
  },

  // Layout
  layout: {
    fillGaps: false,
    horizontal: false,
    alignRight: false,
    alignBottom: false,
    rounding: false,
  },
  layoutOnResize: 150,
  layoutOnInit: true,
  layoutDuration: 300,
  layoutEasing: 'ease',

  // Sorting
  sortData: null,

  // Drag & Drop
  dragEnabled: false,
  dragContainer: null,
  dragHandle: null,
  dragStartPredicate: {
    distance: 0,
    delay: 0,
  },
  dragAxis: 'xy',
  dragSort: true,
  dragSortHeuristics: {
    sortInterval: 100,
    minDragDistance: 10,
    minBounceBackAngle: 1,
  },
  dragSortPredicate: {
    threshold: 50,
    action: ACTION_MOVE,
    migrateAction: ACTION_MOVE,
  },
  dragRelease: {
    duration: 300,
    easing: 'ease',
    useDragContainer: true,
  },
  dragCssProps: {
    touchAction: 'none',
    userSelect: 'none',
    userDrag: 'none',
    tapHighlightColor: 'rgba(0, 0, 0, 0)',
    touchCallout: 'none',
    contentZooming: 'none',
  },
  dragPlaceholder: {
    enabled: false,
    createElement: null,
    onCreate: null,
    onRemove: null,
  },
  dragAutoScroll: {
    targets: [],
    handle: null,
    threshold: 50,
    safeZone: 0.2,
    speed: AutoScroller.smoothSpeed(1000, 2000, 2500),
    sortDuringScroll: true,
    smoothStop: false,
    onStart: null,
    onStop: null,
  },

  // Classnames
  containerClass: 'muuri',
  itemClass: 'muuri-item',
  itemVisibleClass: 'muuri-item-shown',
  itemHiddenClass: 'muuri-item-hidden',
  itemPositioningClass: 'muuri-item-positioning',
  itemDraggingClass: 'muuri-item-dragging',
  itemReleasingClass: 'muuri-item-releasing',
  itemPlaceholderClass: 'muuri-item-placeholder',
};

/**
 * Public prototype methods
 * ************************
 */

/**
 * Bind an event listener.
 *
 * @public
 * @param {String} event
 * @param {Function} listener
 * @returns {Grid}
 */
Grid.prototype.on = function (event, listener) {
  this._emitter.on(event, listener);
  return this;
};

/**
 * Unbind an event listener.
 *
 * @public
 * @param {String} event
 * @param {Function} listener
 * @returns {Grid}
 */
Grid.prototype.off = function (event, listener) {
  this._emitter.off(event, listener);
  return this;
};

/**
 * Get the container element.
 *
 * @public
 * @returns {HTMLElement}
 */
Grid.prototype.getElement = function () {
  return this._element;
};

/**
 * Get instance's item by element or by index. Target can also be an Item
 * instance in which case the function returns the item if it exists within
 * related Grid instance. If nothing is found with the provided target, null
 * is returned.
 *
 * @private
 * @param {(HtmlElement|Number|Item)} [target]
 * @returns {?Item}
 */
Grid.prototype.getItem = function (target) {
  // If no target is specified or the instance is destroyed, return null.
  if (this._isDestroyed || (!target && target !== 0)) {
    return null;
  }

  // If target is number return the item in that index. If the number is lower
  // than zero look for the item starting from the end of the items array. For
  // example -1 for the last item, -2 for the second last item, etc.
  if (typeof target === NUMBER_TYPE) {
    return this._items[target > -1 ? target : this._items.length + target] || null;
  }

  // If the target is an instance of Item return it if it is attached to this
  // Grid instance, otherwise return null.
  if (target instanceof Item) {
    return target._gridId === this._id ? target : null;
  }

  // In other cases let's assume that the target is an element, so let's try
  // to find an item that matches the element and return it. If item is not
  // found return null.
  if (ITEM_ELEMENT_MAP) {
    var item = ITEM_ELEMENT_MAP.get(target);
    return item && item._gridId === this._id ? item : null;
  } else {
    for (var i = 0; i < this._items.length; i++) {
      if (this._items[i]._element === target) {
        return this._items[i];
      }
    }
  }

  return null;
};

/**
 * Get all items. Optionally you can provide specific targets (elements,
 * indices and item instances). All items that are not found are omitted from
 * the returned array.
 *
 * @public
 * @param {(HtmlElement|Number|Item|Array)} [targets]
 * @returns {Item[]}
 */
Grid.prototype.getItems = function (targets) {
  // Return all items immediately if no targets were provided or if the
  // instance is destroyed.
  if (this._isDestroyed || targets === undefined) {
    return this._items.slice(0);
  }

  var items = [];
  var i, item;

  if (Array.isArray(targets) || isNodeList(targets)) {
    for (i = 0; i < targets.length; i++) {
      item = this.getItem(targets[i]);
      if (item) items.push(item);
    }
  } else {
    item = this.getItem(targets);
    if (item) items.push(item);
  }

  return items;
};

/**
 * Update the cached dimensions of the instance's items. By default all the
 * items are refreshed, but you can also provide an array of target items as the
 * first argument if you want to refresh specific items. Note that all hidden
 * items are not refreshed by default since their "display" property is "none"
 * and their dimensions are therefore not readable from the DOM. However, if you
 * do want to force update hidden item dimensions too you can provide `true`
 * as the second argument, which makes the elements temporarily visible while
 * their dimensions are being read.
 *
 * @public
 * @param {Item[]} [items]
 * @param {Boolean} [force=false]
 * @returns {Grid}
 */
Grid.prototype.refreshItems = function (items, force) {
  if (this._isDestroyed) return this;

  var targets = items || this._items;
  var i, item, style, hiddenItemStyles;

  if (force === true) {
    hiddenItemStyles = [];
    for (i = 0; i < targets.length; i++) {
      item = targets[i];
      if (!item.isVisible() && !item.isHiding()) {
        style = item.getElement().style;
        style.visibility = 'hidden';
        style.display = '';
        hiddenItemStyles.push(style);
      }
    }
  }

  for (i = 0; i < targets.length; i++) {
    targets[i]._refreshDimensions(force);
  }

  if (force === true) {
    for (i = 0; i < hiddenItemStyles.length; i++) {
      style = hiddenItemStyles[i];
      style.visibility = '';
      style.display = 'none';
    }
    hiddenItemStyles.length = 0;
  }

  return this;
};

/**
 * Update the sort data of the instance's items. By default all the items are
 * refreshed, but you can also provide an array of target items if you want to
 * refresh specific items.
 *
 * @public
 * @param {Item[]} [items]
 * @returns {Grid}
 */
Grid.prototype.refreshSortData = function (items) {
  if (this._isDestroyed) return this;

  var targets = items || this._items;
  for (var i = 0; i < targets.length; i++) {
    targets[i]._refreshSortData();
  }

  return this;
};

/**
 * Synchronize the item elements to match the order of the items in the DOM.
 * This comes handy if you need to keep the DOM structure matched with the
 * order of the items. Note that if an item's element is not currently a child
 * of the container element (if it is dragged for example) it is ignored and
 * left untouched.
 *
 * @public
 * @returns {Grid}
 */
Grid.prototype.synchronize = function () {
  if (this._isDestroyed) return this;

  var items = this._items;
  if (!items.length) return this;

  var fragment;
  var element;

  for (var i = 0; i < items.length; i++) {
    element = items[i]._element;
    if (element.parentNode === this._element) {
      fragment = fragment || document.createDocumentFragment();
      fragment.appendChild(element);
    }
  }

  if (!fragment) return this;

  this._element.appendChild(fragment);
  this._emit(EVENT_SYNCHRONIZE);

  return this;
};

/**
 * Calculate and apply item positions.
 *
 * @public
 * @param {Boolean} [instant=false]
 * @param {Function} [onFinish]
 * @returns {Grid}
 */
Grid.prototype.layout = function (instant, onFinish) {
  if (this._isDestroyed) return this;

  // Cancel unfinished layout algorithm if possible.
  var unfinishedLayout = this._nextLayoutData;
  if (unfinishedLayout && isFunction(unfinishedLayout.cancel)) {
    unfinishedLayout.cancel();
  }

  // Compute layout id (let's stay in Float32 range).
  layoutId = (layoutId % MAX_SAFE_FLOAT32_INTEGER) + 1;
  var nextLayoutId = layoutId;

  // Store data for next layout.
  this._nextLayoutData = {
    id: nextLayoutId,
    instant: instant,
    onFinish: onFinish,
    cancel: null,
  };

  // Collect layout items (all active grid items).
  var items = this._items;
  var layoutItems = [];
  for (var i = 0; i < items.length; i++) {
    if (items[i]._isActive) layoutItems.push(items[i]);
  }

  // Compute new layout.
  this._refreshDimensions();
  var gridWidth = this._width - this._borderLeft - this._borderRight;
  var gridHeight = this._height - this._borderTop - this._borderBottom;
  var layoutSettings = this._settings.layout;
  var cancelLayout;
  if (isFunction(layoutSettings)) {
    cancelLayout = layoutSettings(
      this,
      nextLayoutId,
      layoutItems,
      gridWidth,
      gridHeight,
      this._onLayoutDataReceived
    );
  } else {
    Grid.defaultPacker.setOptions(layoutSettings);
    cancelLayout = Grid.defaultPacker.createLayout(
      this,
      nextLayoutId,
      layoutItems,
      gridWidth,
      gridHeight,
      this._onLayoutDataReceived
    );
  }

  // Store layout cancel method if available.
  if (
    isFunction(cancelLayout) &&
    this._nextLayoutData &&
    this._nextLayoutData.id === nextLayoutId
  ) {
    this._nextLayoutData.cancel = cancelLayout;
  }

  return this;
};

/**
 * Add new items by providing the elements you wish to add to the instance and
 * optionally provide the index where you want the items to be inserted into.
 * All elements that are not already children of the container element will be
 * automatically appended to the container element. If an element has it's CSS
 * display property set to "none" it will be marked as inactive during the
 * initiation process. As long as the item is inactive it will not be part of
 * the layout, but it will retain it's index. You can activate items at any
 * point with grid.show() method. This method will automatically call
 * grid.layout() if one or more of the added elements are visible. If only
 * hidden items are added no layout will be called. All the new visible items
 * are positioned without animation during their first layout.
 *
 * @public
 * @param {(HTMLElement|HTMLElement[])} elements
 * @param {Object} [options]
 * @param {Number} [options.index=-1]
 * @param {Boolean} [options.active]
 * @param {(Boolean|Function|String)} [options.layout=true]
 * @returns {Item[]}
 */
Grid.prototype.add = function (elements, options) {
  if (this._isDestroyed || !elements) return [];

  var newItems = toArray(elements);
  if (!newItems.length) return newItems;

  var opts = options || {};
  var layout = opts.layout ? opts.layout : opts.layout === undefined;
  var items = this._items;
  var needsLayout = false;
  var fragment;
  var element;
  var item;
  var i;

  // Collect all the elements that are not child of the grid element into a
  // document fragment.
  for (i = 0; i < newItems.length; i++) {
    element = newItems[i];
    if (element.parentNode !== this._element) {
      fragment = fragment || document.createDocumentFragment();
      fragment.appendChild(element);
    }
  }

  // If we have a fragment, let's append it to the grid element. We could just
  // not do this and the `new Item()` instantiation would handle this for us,
  // but this way we can add the elements into the DOM a bit faster.
  if (fragment) {
    this._element.appendChild(fragment);
  }

  // Map provided elements into new grid items.
  for (i = 0; i < newItems.length; i++) {
    element = newItems[i];
    item = newItems[i] = new Item(this, element, opts.active);

    // If the item to be added is active, we need to do a layout. Also, we
    // need to mark the item with the skipNextAnimation flag to make it
    // position instantly (without animation) during the next layout. Without
    // the hack the item would animate to it's new position from the northwest
    // corner of the grid, which feels a bit buggy (imho).
    if (item._isActive) {
      needsLayout = true;
      item._layout._skipNextAnimation = true;
    }
  }

  // Set up the items' initial dimensions and sort data. This needs to be done
  // in a separate loop to avoid layout thrashing.
  for (i = 0; i < newItems.length; i++) {
    item = newItems[i];
    item._refreshDimensions();
    item._refreshSortData();
  }

  // Add the new items to the items collection to correct index.
  arrayInsert(items, newItems, opts.index);

  // Emit add event.
  if (this._hasListeners(EVENT_ADD)) {
    this._emit(EVENT_ADD, newItems.slice(0));
  }

  // If layout is needed.
  if (needsLayout && layout) {
    this.layout(layout === INSTANT_LAYOUT, isFunction(layout) ? layout : undefined);
  }

  return newItems;
};

/**
 * Remove items from the instance.
 *
 * @public
 * @param {Item[]} items
 * @param {Object} [options]
 * @param {Boolean} [options.removeElements=false]
 * @param {(Boolean|Function|String)} [options.layout=true]
 * @returns {Item[]}
 */
Grid.prototype.remove = function (items, options) {
  if (this._isDestroyed || !items.length) return [];

  var opts = options || {};
  var layout = opts.layout ? opts.layout : opts.layout === undefined;
  var needsLayout = false;
  var allItems = this.getItems();
  var targetItems = [];
  var indices = [];
  var index;
  var item;
  var i;

  // Remove the individual items.
  for (i = 0; i < items.length; i++) {
    item = items[i];
    if (item._isDestroyed) continue;

    index = this._items.indexOf(item);
    if (index === -1) continue;

    if (item._isActive) needsLayout = true;

    targetItems.push(item);
    indices.push(allItems.indexOf(item));
    item._destroy(opts.removeElements);
    this._items.splice(index, 1);
  }

  // Emit remove event.
  if (this._hasListeners(EVENT_REMOVE)) {
    this._emit(EVENT_REMOVE, targetItems.slice(0), indices);
  }

  // If layout is needed.
  if (needsLayout && layout) {
    this.layout(layout === INSTANT_LAYOUT, isFunction(layout) ? layout : undefined);
  }

  return targetItems;
};

/**
 * Show specific instance items.
 *
 * @public
 * @param {Item[]} items
 * @param {Object} [options]
 * @param {Boolean} [options.instant=false]
 * @param {Boolean} [options.syncWithLayout=true]
 * @param {Function} [options.onFinish]
 * @param {(Boolean|Function|String)} [options.layout=true]
 * @returns {Grid}
 */
Grid.prototype.show = function (items, options) {
  if (!this._isDestroyed && items.length) {
    this._setItemsVisibility(items, true, options);
  }
  return this;
};

/**
 * Hide specific instance items.
 *
 * @public
 * @param {Item[]} items
 * @param {Object} [options]
 * @param {Boolean} [options.instant=false]
 * @param {Boolean} [options.syncWithLayout=true]
 * @param {Function} [options.onFinish]
 * @param {(Boolean|Function|String)} [options.layout=true]
 * @returns {Grid}
 */
Grid.prototype.hide = function (items, options) {
  if (!this._isDestroyed && items.length) {
    this._setItemsVisibility(items, false, options);
  }
  return this;
};

/**
 * Filter items. Expects at least one argument, a predicate, which should be
 * either a function or a string. The predicate callback is executed for every
 * item in the instance. If the return value of the predicate is truthy the
 * item in question will be shown and otherwise hidden. The predicate callback
 * receives the item instance as it's argument. If the predicate is a string
 * it is considered to be a selector and it is checked against every item
 * element in the instance with the native element.matches() method. All the
 * matching items will be shown and others hidden.
 *
 * @public
 * @param {(Function|String)} predicate
 * @param {Object} [options]
 * @param {Boolean} [options.instant=false]
 * @param {Boolean} [options.syncWithLayout=true]
 * @param {FilterCallback} [options.onFinish]
 * @param {(Boolean|Function|String)} [options.layout=true]
 * @returns {Grid}
 */
Grid.prototype.filter = function (predicate, options) {
  if (this._isDestroyed || !this._items.length) return this;

  var itemsToShow = [];
  var itemsToHide = [];
  var isPredicateString = typeof predicate === STRING_TYPE;
  var isPredicateFn = isFunction(predicate);
  var opts = options || {};
  var isInstant = opts.instant === true;
  var syncWithLayout = opts.syncWithLayout;
  var layout = opts.layout ? opts.layout : opts.layout === undefined;
  var onFinish = isFunction(opts.onFinish) ? opts.onFinish : null;
  var tryFinishCounter = -1;
  var tryFinish = noop;
  var item;
  var i;

  // If we have onFinish callback, let's create proper tryFinish callback.
  if (onFinish) {
    tryFinish = function () {
      ++tryFinishCounter && onFinish(itemsToShow.slice(0), itemsToHide.slice(0));
    };
  }

  // Check which items need to be shown and which hidden.
  if (isPredicateFn || isPredicateString) {
    for (i = 0; i < this._items.length; i++) {
      item = this._items[i];
      if (isPredicateFn ? predicate(item) : elementMatches(item._element, predicate)) {
        itemsToShow.push(item);
      } else {
        itemsToHide.push(item);
      }
    }
  }

  // Show items that need to be shown.
  if (itemsToShow.length) {
    this.show(itemsToShow, {
      instant: isInstant,
      syncWithLayout: syncWithLayout,
      onFinish: tryFinish,
      layout: false,
    });
  } else {
    tryFinish();
  }

  // Hide items that need to be hidden.
  if (itemsToHide.length) {
    this.hide(itemsToHide, {
      instant: isInstant,
      syncWithLayout: syncWithLayout,
      onFinish: tryFinish,
      layout: false,
    });
  } else {
    tryFinish();
  }

  // If there are any items to filter.
  if (itemsToShow.length || itemsToHide.length) {
    // Emit filter event.
    if (this._hasListeners(EVENT_FILTER)) {
      this._emit(EVENT_FILTER, itemsToShow.slice(0), itemsToHide.slice(0));
    }

    // If layout is needed.
    if (layout) {
      this.layout(layout === INSTANT_LAYOUT, isFunction(layout) ? layout : undefined);
    }
  }

  return this;
};

/**
 * Sort items. There are three ways to sort the items. The first is simply by
 * providing a function as the comparer which works identically to native
 * array sort. Alternatively you can sort by the sort data you have provided
 * in the instance's options. Just provide the sort data key(s) as a string
 * (separated by space) and the items will be sorted based on the provided
 * sort data keys. Lastly you have the opportunity to provide a presorted
 * array of items which will be used to sync the internal items array in the
 * same order.
 *
 * @public
 * @param {(Function|String|Item[])} comparer
 * @param {Object} [options]
 * @param {Boolean} [options.descending=false]
 * @param {(Boolean|Function|String)} [options.layout=true]
 * @returns {Grid}
 */
Grid.prototype.sort = (function () {
  var sortComparer;
  var isDescending;
  var origItems;
  var indexMap;

  function defaultComparer(a, b) {
    var result = 0;
    var criteriaName;
    var criteriaOrder;
    var valA;
    var valB;

    // Loop through the list of sort criteria.
    for (var i = 0; i < sortComparer.length; i++) {
      // Get the criteria name, which should match an item's sort data key.
      criteriaName = sortComparer[i][0];
      criteriaOrder = sortComparer[i][1];

      // Get items' cached sort values for the criteria. If the item has no sort
      // data let's update the items sort data (this is a lazy load mechanism).
      valA = (a._sortData ? a : a._refreshSortData())._sortData[criteriaName];
      valB = (b._sortData ? b : b._refreshSortData())._sortData[criteriaName];

      // Sort the items in descending order if defined so explicitly. Otherwise
      // sort items in ascending order.
      if (criteriaOrder === 'desc' || (!criteriaOrder && isDescending)) {
        result = valB < valA ? -1 : valB > valA ? 1 : 0;
      } else {
        result = valA < valB ? -1 : valA > valB ? 1 : 0;
      }

      // If we have -1 or 1 as the return value, let's return it immediately.
      if (result) return result;
    }

    // If values are equal let's compare the item indices to make sure we
    // have a stable sort. Note that this is not necessary in evergreen browsers
    // because Array.sort() is nowadays stable. However, in order to guarantee
    // same results in older browsers we need this.
    if (!result) {
      if (!indexMap) indexMap = createIndexMap(origItems);
      result = isDescending ? compareIndexMap(indexMap, b, a) : compareIndexMap(indexMap, a, b);
    }
    return result;
  }

  function customComparer(a, b) {
    var result = isDescending ? -sortComparer(a, b) : sortComparer(a, b);
    if (!result) {
      if (!indexMap) indexMap = createIndexMap(origItems);
      result = isDescending ? compareIndexMap(indexMap, b, a) : compareIndexMap(indexMap, a, b);
    }
    return result;
  }

  return function (comparer, options) {
    if (this._isDestroyed || this._items.length < 2) return this;

    var items = this._items;
    var opts = options || {};
    var layout = opts.layout ? opts.layout : opts.layout === undefined;

    // Setup parent scope data.
    isDescending = !!opts.descending;
    origItems = items.slice(0);
    indexMap = null;

    // If function is provided do a native array sort.
    if (isFunction(comparer)) {
      sortComparer = comparer;
      items.sort(customComparer);
    }
    // Otherwise if we got a string, let's sort by the sort data as provided in
    // the instance's options.
    else if (typeof comparer === STRING_TYPE) {
      sortComparer = comparer
        .trim()
        .split(' ')
        .filter(function (val) {
          return val;
        })
        .map(function (val) {
          return val.split(':');
        });
      items.sort(defaultComparer);
    }
    // Otherwise if we got an array, let's assume it's a presorted array of the
    // items and order the items based on it. Here we blindly trust that the
    // presorted array consists of the same item instances as the current
    // `gird._items` array.
    else if (Array.isArray(comparer)) {
      items.length = 0;
      items.push.apply(items, comparer);
    }
    // Otherwise let's throw an error.
    else {
      sortComparer = isDescending = origItems = indexMap = null;
      throw new Error('Invalid comparer argument provided.');
    }

    // Emit sort event.
    if (this._hasListeners(EVENT_SORT)) {
      this._emit(EVENT_SORT, items.slice(0), origItems);
    }

    // If layout is needed.
    if (layout) {
      this.layout(layout === INSTANT_LAYOUT, isFunction(layout) ? layout : undefined);
    }

    // Reset data (to avoid mem leaks).
    sortComparer = isDescending = origItems = indexMap = null;

    return this;
  };
})();

/**
 * Move item to another index or in place of another item.
 *
 * @public
 * @param {(HtmlElement|Number|Item)} item
 * @param {(HtmlElement|Number|Item)} position
 * @param {Object} [options]
 * @param {String} [options.action="move"]
 *   - Accepts either "move" or "swap".
 *   - "move" moves the item in place of the other item.
 *   - "swap" swaps the position of the items.
 * @param {(Boolean|Function|String)} [options.layout=true]
 * @returns {Grid}
 */
Grid.prototype.move = function (item, position, options) {
  if (this._isDestroyed || this._items.length < 2) return this;

  var items = this._items;
  var opts = options || {};
  var layout = opts.layout ? opts.layout : opts.layout === undefined;
  var isSwap = opts.action === ACTION_SWAP;
  var action = isSwap ? ACTION_SWAP : ACTION_MOVE;
  var fromItem = this.getItem(item);
  var toItem = this.getItem(position);
  var fromIndex;
  var toIndex;

  // Make sure the items exist and are not the same.
  if (fromItem && toItem && fromItem !== toItem) {
    // Get the indices of the items.
    fromIndex = items.indexOf(fromItem);
    toIndex = items.indexOf(toItem);

    // Do the move/swap.
    if (isSwap) {
      arraySwap(items, fromIndex, toIndex);
    } else {
      arrayMove(items, fromIndex, toIndex);
    }

    // Emit move event.
    if (this._hasListeners(EVENT_MOVE)) {
      this._emit(EVENT_MOVE, {
        item: fromItem,
        fromIndex: fromIndex,
        toIndex: toIndex,
        action: action,
      });
    }

    // If layout is needed.
    if (layout) {
      this.layout(layout === INSTANT_LAYOUT, isFunction(layout) ? layout : undefined);
    }
  }

  return this;
};

/**
 * Send item to another Grid instance.
 *
 * @public
 * @param {(HtmlElement|Number|Item)} item
 * @param {Grid} targetGrid
 * @param {(HtmlElement|Number|Item)} position
 * @param {Object} [options]
 * @param {HTMLElement} [options.appendTo=document.body]
 * @param {(Boolean|Function|String)} [options.layoutSender=true]
 * @param {(Boolean|Function|String)} [options.layoutReceiver=true]
 * @returns {Grid}
 */
Grid.prototype.send = function (item, targetGrid, position, options) {
  if (this._isDestroyed || targetGrid._isDestroyed || this === targetGrid) return this;

  // Make sure we have a valid target item.
  item = this.getItem(item);
  if (!item) return this;

  var opts = options || {};
  var container = opts.appendTo || document.body;
  var layoutSender = opts.layoutSender ? opts.layoutSender : opts.layoutSender === undefined;
  var layoutReceiver = opts.layoutReceiver
    ? opts.layoutReceiver
    : opts.layoutReceiver === undefined;

  // Start the migration process.
  item._migrate.start(targetGrid, position, container);

  // If migration was started successfully and the item is active, let's layout
  // the grids.
  if (item._migrate._isActive && item._isActive) {
    if (layoutSender) {
      this.layout(
        layoutSender === INSTANT_LAYOUT,
        isFunction(layoutSender) ? layoutSender : undefined
      );
    }
    if (layoutReceiver) {
      targetGrid.layout(
        layoutReceiver === INSTANT_LAYOUT,
        isFunction(layoutReceiver) ? layoutReceiver : undefined
      );
    }
  }

  return this;
};

/**
 * Destroy the instance.
 *
 * @public
 * @param {Boolean} [removeElements=false]
 * @returns {Grid}
 */
Grid.prototype.destroy = function (removeElements) {
  if (this._isDestroyed) return this;

  var container = this._element;
  var items = this._items.slice(0);
  var layoutStyles = (this._layout && this._layout.styles) || {};
  var i, prop;

  // Unbind window resize event listener.
  unbindLayoutOnResize(this);

  // Destroy items.
  for (i = 0; i < items.length; i++) items[i]._destroy(removeElements);
  this._items.length = 0;

  // Restore container.
  removeClass(container, this._settings.containerClass);
  for (prop in layoutStyles) container.style[prop] = '';

  // Emit destroy event and unbind all events.
  this._emit(EVENT_DESTROY);
  this._emitter.destroy();

  // Remove reference from the grid instances collection.
  delete GRID_INSTANCES[this._id];

  // Flag instance as destroyed.
  this._isDestroyed = true;

  return this;
};

/**
 * Private prototype methods
 * *************************
 */

/**
 * Emit a grid event.
 *
 * @private
 * @param {String} event
 * @param {...*} [arg]
 */
Grid.prototype._emit = function () {
  if (this._isDestroyed) return;
  this._emitter.emit.apply(this._emitter, arguments);
};

/**
 * Check if there are any events listeners for an event.
 *
 * @private
 * @param {String} event
 * @returns {Boolean}
 */
Grid.prototype._hasListeners = function (event) {
  if (this._isDestroyed) return false;
  return this._emitter.countListeners(event) > 0;
};

/**
 * Update container's width, height and offsets.
 *
 * @private
 */
Grid.prototype._updateBoundingRect = function () {
  var element = this._element;
  var rect = element.getBoundingClientRect();
  this._width = rect.width;
  this._height = rect.height;
  this._left = rect.left;
  this._top = rect.top;
  this._right = rect.right;
  this._bottom = rect.bottom;
};

/**
 * Update container's border sizes.
 *
 * @private
 * @param {Boolean} left
 * @param {Boolean} right
 * @param {Boolean} top
 * @param {Boolean} bottom
 */
Grid.prototype._updateBorders = function (left, right, top, bottom) {
  var element = this._element;
  if (left) this._borderLeft = getStyleAsFloat(element, 'border-left-width');
  if (right) this._borderRight = getStyleAsFloat(element, 'border-right-width');
  if (top) this._borderTop = getStyleAsFloat(element, 'border-top-width');
  if (bottom) this._borderBottom = getStyleAsFloat(element, 'border-bottom-width');
};

/**
 * Refresh all of container's internal dimensions and offsets.
 *
 * @private
 */
Grid.prototype._refreshDimensions = function () {
  this._updateBoundingRect();
  this._updateBorders(1, 1, 1, 1);
  this._boxSizing = getStyle(this._element, 'box-sizing');
};

/**
 * Calculate and apply item positions.
 *
 * @private
 * @param {Object} layout
 */
Grid.prototype._onLayoutDataReceived = (function () {
  var itemsToLayout = [];
  return function (layout) {
    if (this._isDestroyed || !this._nextLayoutData || this._nextLayoutData.id !== layout.id) return;

    var grid = this;
    var instant = this._nextLayoutData.instant;
    var onFinish = this._nextLayoutData.onFinish;
    var numItems = layout.items.length;
    var counter = numItems;
    var item;
    var left;
    var top;
    var i;

    // Reset next layout data.
    this._nextLayoutData = null;

    if (!this._isLayoutFinished && this._hasListeners(EVENT_LAYOUT_ABORT)) {
      this._emit(EVENT_LAYOUT_ABORT, this._layout.items.slice(0));
    }

    // Update the layout reference.
    this._layout = layout;

    // Update the item positions and collect all items that need to be laid
    // out. It is critical that we update the item position _before_ the
    // layoutStart event as the new data might be needed in the callback.
    itemsToLayout.length = 0;
    for (i = 0; i < numItems; i++) {
      item = layout.items[i];

      // Make sure we have a matching item.
      if (!item) {
        --counter;
        continue;
      }

      // Get the item's new left and top values.
      left = layout.slots[i * 2];
      top = layout.slots[i * 2 + 1];

      // Let's skip the layout process if we can. Possibly avoids a lot of DOM
      // operations which saves us some CPU cycles.
      if (item._canSkipLayout(left, top)) {
        --counter;
        continue;
      }

      // Update the item's position.
      item._left = left;
      item._top = top;

      // Only active non-dragged items need to be moved.
      if (item.isActive() && !item.isDragging()) {
        itemsToLayout.push(item);
      } else {
        --counter;
      }
    }

    // Set layout styles to the grid element.
    if (layout.styles) {
      setStyles(this._element, layout.styles);
    }

    // layoutStart event is intentionally emitted after the container element's
    // dimensions are set, because otherwise there would be no hook for reacting
    // to container dimension changes.
    if (this._hasListeners(EVENT_LAYOUT_START)) {
      this._emit(EVENT_LAYOUT_START, layout.items.slice(0), instant === true);
      // Let's make sure that the current layout process has not been overridden
      // in the layoutStart event, and if so, let's stop processing the aborted
      // layout.
      if (this._layout.id !== layout.id) return;
    }

    var tryFinish = function () {
      if (--counter > 0) return;

      var hasLayoutChanged = grid._layout.id !== layout.id;
      var callback = isFunction(instant) ? instant : onFinish;

      if (!hasLayoutChanged) {
        grid._isLayoutFinished = true;
      }

      if (isFunction(callback)) {
        callback(layout.items.slice(0), hasLayoutChanged);
      }

      if (!hasLayoutChanged && grid._hasListeners(EVENT_LAYOUT_END)) {
        grid._emit(EVENT_LAYOUT_END, layout.items.slice(0));
      }
    };

    if (!itemsToLayout.length) {
      tryFinish();
      return this;
    }

    this._isLayoutFinished = false;

    for (i = 0; i < itemsToLayout.length; i++) {
      if (this._layout.id !== layout.id) break;
      itemsToLayout[i]._layout.start(instant === true, tryFinish);
    }

    if (this._layout.id === layout.id) {
      itemsToLayout.length = 0;
    }

    return this;
  };
})();

/**
 * Show or hide Grid instance's items.
 *
 * @private
 * @param {Item[]} items
 * @param {Boolean} toVisible
 * @param {Object} [options]
 * @param {Boolean} [options.instant=false]
 * @param {Boolean} [options.syncWithLayout=true]
 * @param {Function} [options.onFinish]
 * @param {(Boolean|Function|String)} [options.layout=true]
 */
Grid.prototype._setItemsVisibility = function (items, toVisible, options) {
  var grid = this;
  var targetItems = items.slice(0);
  var opts = options || {};
  var isInstant = opts.instant === true;
  var callback = opts.onFinish;
  var layout = opts.layout ? opts.layout : opts.layout === undefined;
  var counter = targetItems.length;
  var startEvent = toVisible ? EVENT_SHOW_START : EVENT_HIDE_START;
  var endEvent = toVisible ? EVENT_SHOW_END : EVENT_HIDE_END;
  var method = toVisible ? 'show' : 'hide';
  var needsLayout = false;
  var completedItems = [];
  var hiddenItems = [];
  var item;
  var i;

  // If there are no items call the callback, but don't emit any events.
  if (!counter) {
    if (isFunction(callback)) callback(targetItems);
    return;
  }

  // Prepare the items.
  for (i = 0; i < targetItems.length; i++) {
    item = targetItems[i];

    // If inactive item is shown or active item is hidden we need to do
    // layout.
    if ((toVisible && !item._isActive) || (!toVisible && item._isActive)) {
      needsLayout = true;
    }

    // If inactive item is shown we also need to do a little hack to make the
    // item not animate it's next positioning (layout).
    item._layout._skipNextAnimation = !!(toVisible && !item._isActive);

    // If a hidden item is being shown we need to refresh the item's
    // dimensions.
    if (toVisible && item._visibility._isHidden) {
      hiddenItems.push(item);
    }

    // Add item to layout or remove it from layout.
    if (toVisible) {
      item._addToLayout();
    } else {
      item._removeFromLayout();
    }
  }

  // Force refresh the dimensions of all hidden items.
  if (hiddenItems.length) {
    this.refreshItems(hiddenItems, true);
    hiddenItems.length = 0;
  }

  // Show the items in sync with the next layout.
  function triggerVisibilityChange() {
    if (needsLayout && opts.syncWithLayout !== false) {
      grid.off(EVENT_LAYOUT_START, triggerVisibilityChange);
    }

    if (grid._hasListeners(startEvent)) {
      grid._emit(startEvent, targetItems.slice(0));
    }

    for (i = 0; i < targetItems.length; i++) {
      // Make sure the item is still in the original grid. There is a chance
      // that the item starts migrating before tiggerVisibilityChange is called.
      if (targetItems[i]._gridId !== grid._id) {
        if (--counter < 1) {
          if (isFunction(callback)) callback(completedItems.slice(0));
          if (grid._hasListeners(endEvent)) grid._emit(endEvent, completedItems.slice(0));
        }
        continue;
      }

      targetItems[i]._visibility[method](isInstant, function (interrupted, item) {
        // If the current item's animation was not interrupted add it to the
        // completedItems array.
        if (!interrupted) completedItems.push(item);

        // If all items have finished their animations call the callback
        // and emit showEnd/hideEnd event.
        if (--counter < 1) {
          if (isFunction(callback)) callback(completedItems.slice(0));
          if (grid._hasListeners(endEvent)) grid._emit(endEvent, completedItems.slice(0));
        }
      });
    }
  }

  // Trigger the visibility change, either async with layout or instantly.
  if (needsLayout && opts.syncWithLayout !== false) {
    this.on(EVENT_LAYOUT_START, triggerVisibilityChange);
  } else {
    triggerVisibilityChange();
  }

  // Trigger layout if needed.
  if (needsLayout && layout) {
    this.layout(layout === INSTANT_LAYOUT, isFunction(layout) ? layout : undefined);
  }
};

/**
 * Private helpers
 * ***************
 */

/**
 * Merge default settings with user settings. The returned object is a new
 * object with merged values. The merging is a deep merge meaning that all
 * objects and arrays within the provided settings objects will be also merged
 * so that modifying the values of the settings object will have no effect on
 * the returned object.
 *
 * @param {Object} defaultSettings
 * @param {Object} [userSettings]
 * @returns {Object} Returns a new object.
 */
function mergeSettings(defaultSettings, userSettings) {
  // Create a fresh copy of default settings.
  var settings = mergeObjects({}, defaultSettings);

  // Merge user settings to default settings.
  if (userSettings) {
    settings = mergeObjects(settings, userSettings);
  }

  // Handle visible/hidden styles manually so that the whole object is
  // overridden instead of the props.

  if (userSettings && userSettings.visibleStyles) {
    settings.visibleStyles = userSettings.visibleStyles;
  } else if (defaultSettings && defaultSettings.visibleStyles) {
    settings.visibleStyles = defaultSettings.visibleStyles;
  }

  if (userSettings && userSettings.hiddenStyles) {
    settings.hiddenStyles = userSettings.hiddenStyles;
  } else if (defaultSettings && defaultSettings.hiddenStyles) {
    settings.hiddenStyles = defaultSettings.hiddenStyles;
  }

  return settings;
}

/**
 * Merge two objects recursively (deep merge). The source object's properties
 * are merged to the target object.
 *
 * @param {Object} target
 *   - The target object.
 * @param {Object} source
 *   - The source object.
 * @returns {Object} Returns the target object.
 */
function mergeObjects(target, source) {
  var sourceKeys = Object.keys(source);
  var length = sourceKeys.length;
  var isSourceObject;
  var propName;
  var i;

  for (i = 0; i < length; i++) {
    propName = sourceKeys[i];
    isSourceObject = isPlainObject(source[propName]);

    // If target and source values are both objects, merge the objects and
    // assign the merged value to the target property.
    if (isPlainObject(target[propName]) && isSourceObject) {
      target[propName] = mergeObjects(mergeObjects({}, target[propName]), source[propName]);
      continue;
    }

    // If source's value is object and target's is not let's clone the object as
    // the target's value.
    if (isSourceObject) {
      target[propName] = mergeObjects({}, source[propName]);
      continue;
    }

    // If source's value is an array let's clone the array as the target's
    // value.
    if (Array.isArray(source[propName])) {
      target[propName] = source[propName].slice(0);
      continue;
    }

    // In all other cases let's just directly assign the source's value as the
    // target's value.
    target[propName] = source[propName];
  }

  return target;
}

/**
 * Collect and return initial items for grid.
 *
 * @param {HTMLElement} gridElement
 * @param {?(HTMLElement[]|NodeList|HtmlCollection|String)} elements
 * @returns {(HTMLElement[]|NodeList|HtmlCollection)}
 */
function getInitialGridElements(gridElement, elements) {
  // If we have a wildcard selector let's return all the children.
  if (elements === '*') {
    return gridElement.children;
  }

  // If we have some more specific selector, let's filter the elements.
  if (typeof elements === STRING_TYPE) {
    var result = [];
    var children = gridElement.children;
    for (var i = 0; i < children.length; i++) {
      if (elementMatches(children[i], elements)) {
        result.push(children[i]);
      }
    }
    return result;
  }

  // If we have an array of elements or a node list.
  if (Array.isArray(elements) || isNodeList(elements)) {
    return elements;
  }

  // Otherwise just return an empty array.
  return [];
}

/**
 * Bind grid's resize handler to window.
 *
 * @param {Grid} grid
 * @param {(Number|Boolean)} delay
 */
function bindLayoutOnResize(grid, delay) {
  if (typeof delay !== NUMBER_TYPE) {
    delay = delay === true ? 0 : -1;
  }

  if (delay >= 0) {
    grid._resizeHandler = debounce(function () {
      grid.refreshItems().layout();
    }, delay);

    window.addEventListener('resize', grid._resizeHandler);
  }
}

/**
 * Unbind grid's resize handler from window.
 *
 * @param {Grid} grid
 */
function unbindLayoutOnResize(grid) {
  if (grid._resizeHandler) {
    grid._resizeHandler(true);
    window.removeEventListener('resize', grid._resizeHandler);
    grid._resizeHandler = null;
  }
}

/**
 * Normalize style declaration object, returns a normalized (new) styles object
 * (prefixed properties and invalid properties removed).
 *
 * @param {Object} styles
 * @returns {Object}
 */
function normalizeStyles(styles) {
  var normalized = {};
  var docElemStyle = document.documentElement.style;
  var prop, prefixedProp;

  // Normalize visible styles (prefix and remove invalid).
  for (prop in styles) {
    if (!styles[prop]) continue;
    prefixedProp = getPrefixedPropName(docElemStyle, prop);
    if (!prefixedProp) continue;
    normalized[prefixedProp] = styles[prop];
  }

  return normalized;
}

/**
 * Create index map from items.
 *
 * @param {Item[]} items
 * @returns {Object}
 */
function createIndexMap(items) {
  var result = {};
  for (var i = 0; i < items.length; i++) {
    result[items[i]._id] = i;
  }
  return result;
}

/**
 * Sort comparer function for items' index map.
 *
 * @param {Object} indexMap
 * @param {Item} itemA
 * @param {Item} itemB
 * @returns {Number}
 */
function compareIndexMap(indexMap, itemA, itemB) {
  var indexA = indexMap[itemA._id];
  var indexB = indexMap[itemB._id];
  return indexA - indexB;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Grid);


/***/ }),

/***/ "./node_modules/process/browser.js":
/*!*****************************************!*\
  !*** ./node_modules/process/browser.js ***!
  \*****************************************/
/***/ ((module) => {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


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
/******/ 	/* webpack/runtime/global */
/******/ 	(() => {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
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
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/admin.js ***!
  \*******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var alpinejs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! alpinejs */ "./node_modules/alpinejs/dist/module.esm.js");
/* harmony import */ var _alpinejs_persist__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @alpinejs/persist */ "./node_modules/@alpinejs/persist/dist/module.esm.js");
/* harmony import */ var muuri__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! muuri */ "./node_modules/muuri/dist/muuri.module.js");




var axios = (__webpack_require__(/*! axios */ "./node_modules/axios/index.js")["default"]);

window.Alpine = alpinejs__WEBPACK_IMPORTED_MODULE_0__["default"];
alpinejs__WEBPACK_IMPORTED_MODULE_0__["default"].plugin(_alpinejs_persist__WEBPACK_IMPORTED_MODULE_1__["default"]);
window.Muuri = muuri__WEBPACK_IMPORTED_MODULE_2__["default"];
window.axios = axios;
alpinejs__WEBPACK_IMPORTED_MODULE_0__["default"].start();
})();

// This entry need to be wrapped in an IIFE because it need to be isolated against other entry modules.
(() => {
/*!**************************************!*\
  !*** ./resources/js/custom_admin.js ***!
  \**************************************/
var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);

if (urlParams.has('iframe')) {
  $('.app-header').css({
    display: 'none'
  });
  $('.sidebar.sidebar-pills').css({
    display: 'none'
  });
  $('.breadcrumb').css({
    display: 'none'
  });
  $('main > section.container-fluid h2').css({
    display: 'none'
  }); // remove paddings

  $('.main').removeClass('pt-2');
  $('.container-fluid').css({
    padding: '0'
  }); // clean save button

  $('#btnGroupDrop1').parent().remove();
  $('.btn-success').html("\n    <span class=\"la la-save\" role=\"presentation\" aria-hidden=\"true\"></span> &nbsp;\n    <span data-value=\"save_and_edit\">\u0630\u062E\u06CC\u0631\u0647</span>\n    ");
  document.querySelector("#saveActions").addEventListener('click', function () {
    var event = new CustomEvent('widgetmodalclose');
    setTimeout(function () {
      window.parent.window.dispatchEvent(event);
    }, 700);
    return true;
  });
} else {
  /* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
  var prevScrollpos = window.pageYOffset;

  window.onscroll = function () {
    if (document.getElementById("saveActions")) {
      var currentScrollPos = window.pageYOffset;

      if (prevScrollpos > currentScrollPos) {
        document.getElementById("saveActions").style.bottom = "0";
      } else {
        document.getElementById("saveActions").style.bottom = "-70px";
      }

      prevScrollpos = currentScrollPos;
    }
  };
}

document.addEventListener("DOMContentLoaded", function () {
  $(".loader").delay(1000).fadeOut("slow");
  $.when($("#overlayer").delay(1000).fadeOut("slow")).done(function () {
    $('body').delay(1000).removeClass('h-100vh');
  });
});
})();

/******/ })()
;