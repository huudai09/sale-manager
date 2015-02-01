/*
 * Author: huudai09
 - run on
 - run when
 - name for module
 - extend from another Object
 */

function Module(act) {
    var _ = this.ultilFn;

    var methods = act || {}, cond;
    methods.global = window;
    methods.doc = document;
    methods.parent = {};

    // setup some presets
    var settings = _.mixins({
        run_on: 'ready',
        run_when: true
    }, methods.settings);

    // extend from another Object
    !!settings.extend && (methods.parent = Object.create(settings.extend));

    // check condition for run the module
    cond = _.isBool(settings.run_when) ? settings.run_when
            : (_.isF(settings.run_when) ? !!settings.run_when(_)  // run && convert to bool
                    : (_.isS(settings.run_when) ? _.getPath(settings.run_when)
                            : false));

    // freeze and hide global properties
    ['global', 'doc', 'parent', 'init', 'over'].forEach(function(i) {
        methods.hasOwnProperty(i) && Object.defineProperty(methods, i, {
            configurable: false,
            enumerable: false
        });
    });

    // name object
    this.nameModule(settings.name, methods);

    // run module immediately
    this.run = function() {
        // call init function first
        methods.hasOwnProperty('init')
                && _.isF(methods['init'])
                && methods['init']();

        // call another methods have the suffix 'Action'
        for (var x in methods) {
            _.isF(methods[x])
                    && /Action/.test(x.slice(-6)) && (x.length > 6)
                    && methods[x]();
        }

        // call over function last
        methods.hasOwnProperty('over')
                && _.isF(methods['over'])
                && methods['over']();
        return;
    };

    _.triggerOn(settings.run_on, this.run, cond);
}

Module.prototype.ultilFn = {
    // ultil function
    isF: function(fn) {
        return typeof fn === 'function';
    }

    , isS: function(s) {
        return typeof s === 'string';
    }

    , isBool: function(b) {
        return typeof b === 'boolean';
    }

    , mixins: function(out) {
        out = out || {};

        for (var i = 1; i < arguments.length; i++) {
            if (!arguments[i])
                continue;

            for (var key in arguments[i]) {
                if (arguments[i].hasOwnProperty(key))
                    out[key] = arguments[i][key];
            }
        }

        return out;
    }

    , getPath: function(s) {
        var pathname = window.location.pathname.toLowerCase()
                .replace(/\//g, '.')
                .replace(/(^\.|\.$)/g, '');

        if (this.isBool(s) && s)
            return pathname;

        return !!~(pathname.indexOf(s.toLowerCase()));
    }

    , triggerOn: function(type, fn, cond) {
        return ({
            'ready': function(cb) {
                jQuery(function() {
                    cond && cb();
                });
            },
            'load': function(cb) {
                jQuery(window).load(function() {
                    cond && cb();
                });
            }
        })[type](fn);
    }
};

Module.prototype.nameModule = function(name, prop) {

    if (!this.ultilFn.isS(name) || !prop)
        return;

    if (!window['Mod'])
        window['Mod'] = {};

    !window['Mod'][name]
            && (window['Mod'][name] = prop);
};

/*
 *   Example
 *
 var anotherObj = {
 killAction: function(){
 console.log('kill action from another object');
 }
 };

 new Module({

 settings: {
 run_on: 'load', // 'load' || 'ready',
 run_when: 'github.module',
 name: 'ModuleName',
 extend: anotherObj
 },

 init: function(){
 window.console.log('initialize module');
 this.vaa = '123456';
 },

 over: function(){
 console.log('run at the bottom of object');
 },

 fooAction: function(){
 console.log('foo Action');
 console.log(this.vaa);
 },

 barAction: function(){
 console.log('bar Action');
 console.log(this);
 }
 });
 *
 *
 */