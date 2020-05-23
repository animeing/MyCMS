
window.addEventListener('load',()=>{
    window.fixed = document.getElementById('fixed-window');
})

class MouseEventEnum {
    /**
     * mousedown
     */
    static get DOWN(){
        return 'mousedown';
    }
    /**
     * mouseup
     */
    static get UP(){
        return 'mouseup';
    }
    /**
     * click
     */
    static get CLICK(){
        return 'click';
    }
    /**
     * mouseover
     */
    static get OVER(){
        return 'mouseover';
    }
    /**
     * mouseout
     */
    static get OUT(){
        return 'mouseout';
    }

    static get MOUSE_MOVE(){
        return 'mousemove';
    }
}

const Base64 = {
    encode: (str)=> {
        try{
            if(str == null){
                return ;
            }
            return btoa(unescape(encodeURIComponent(str)));
        } catch(e){
            console.log('Exception');
            return null;
        }
    },
    decode: (str)=> {
        try{
            if(str == null){
                return ;
            }
            return decodeURIComponent(escape(atob(str)));
        } catch(e){
            console.log('Exception');
            return null;
        }
    }
};

/**
 * @template T
 */
class List{
    /**
     * @param {Array} array
     */
    constructor(array = []){
        this.changeEvents = [];
        this.array = array;
    }
    
    static [Symbol.hasInstance](instance) {
        if(Array.isArray(instance.array)) return true;
        return false;
    }
    /**
     * @returns {array}
     */
    gets(){
        return this.array;
    }

    get length(){
        return this.array.length;
    }

    *[Symbol.iterator](){
        for(const value of this.gets()){
            yield value;
        }
    }
    
    /**
     * @param {List|Array|Iterator} list
     */
    addAll(list){
        for (const iterator of list) {
            this.add(iterator);
        }
    }

    /**
     * adding data
     * @param {T} value 
     * @param {Number} index start = 0
     */
    add(value, index = this.length){
        if(this.length === index){
            this.array[index] = value;
        } else {
            this.array.splice(index, 0, value);
        }
        for (const che of this.changeEvents) {
            if(typeof(che) == 'function') che(value);
        }
    }
    /**
     * remove data
     * @param {T} value 
     */
    remove(value){
        for(let data in this.array){
            if(value === this.array[data]){
                delete this.array[data];
                for (const che of instance.changeEvents) {
                    if(typeof(che) == 'function') che(this.array[data]);
                }
                return;
            }
        }
    }
    /**
     * @param {Number} index
     * @returns {T}
     */
    get(index){
        return this.array[index];
    }
    /**
     * remove all data
     */
    removeAll(){
        this.array = [];
    }

    /**
     * 
     * @param {T} value 
     * @returns {Number}
     */
    equalFindIndex(value){
        return this.array.findIndex(item => item === value);
    }

    deepEquals(value){
        try{
            if(this.length !== value.length){
                return false;
            }
            const selfArray = this.gets();
            const otherArray = value.gets();
            for (let index = 0; index < selfArray.length; index++) {
                if(selfArray[index] !== otherArray[index]){
                    return false;
                }
            }
            return true;
        }catch(e){
            return false;    
        }
    }
    
    count(){
        return Object.keys(this.array).length;
    }

    changeEvent(func){
        this.changeEvents[this.changeEvents.length] = func;
    }
}

/**
 * @abstract
 */
class StorageMap{
    constructor(){
    }
    static get [Symbol.species](){
        return StorageMap;
    }
    /**
     * @protected
     * @returns {Storage}
     */
    getStorage(){
        return undefined;
    }
    /**
     * @readonly
     */
    get length(){
        return this.getStorage().length;
    }
    *[Symbol.iterator](){
        for (let index = 0; index < this.length; index++) {
            const key = this.getStorage().key(index);
            const value = this.get(key);
            yield [key , value];
        }
    }
    
    *keys(){
        for (let index = 0; index < this.length; index++) {
            yield(this.getStorage().key(index));
        }
    }

    *values(){
        for (let index = 0; index < this.length; index++) {
            yield this.get(this.getStorage().key(index));
        }
    }

    delete(key){
        this.getStorage().removeItem(key);
    }

    set(key, value){
        this.getStorage().setItem(key, value);
    }

    get(key){
        return this.getStorage().getItem(key);
    }

    clear(){
        for (const key of this.keys()) {
            this.getStorage().removeItem(key);
        }
    }

    has(key){
        return this.get(key) !== null;
    }
}

class CookieMap{
    _savePath = '';
    constructor(savePath = ''){
        this._savePath = savePath;
    }

    *[Symbol.iterator](){
        let cookies = document.cookie.split('; ');
        for(const cookie of cookies){
            if(cookie === ''){
                continue;
            }
            const split = cookie.match('([^\S= ]*)=([A-z0-9=]*)');
            try {
                yield [split[1] , Base64.decode(split[2])];
            } catch (error) {
                
            }
        }
    }

    get(key){
        return Base64.decode(((document.cookie + '; ').match('['+key+'= ]=([A-z0-9=]*)')||[])[1]);
    }

    get path(){
        return this._savePath;
    }

    /**
     * 
     * @override
     * @param {*} key 
     * @param {*} value 
     */
    set(key, value){
        console.log(key+'='+Base64.encode(value)+';'+this.path);
        document.cookie = key+'='+Base64.encode(value)+';'+this.path;
    }

    /**
     * 
     * @override
     * @param {*} key 
     */
    delete(key){
        document.cookie = key+'=; max-age=0';
    }
}

class LocalStorageMap extends StorageMap{
    static get [Symbol.species](){
        return LocalStorageMap;
    }
    getStorage(){
        return window.localStorage;
    }
}

class SessionStorageMap extends StorageMap{
    static get [Symbol.species](){
        return SessionStorageMap;
    }
    getStorage(){
        return window.sessionStorage;
    }
}


class Point2D{
    constructor(){
        this.x = 0;
        this.y = 0;
    }
}

class DisplayPoint extends Point2D{
    constructor(){
        super();
    }
    isHorizontalOverFlow(horizontalSize = 0){
        let htmlWidth = htmlElement().clientWidth;
        return htmlWidth < this.x + horizontalSize;
    }
    isVerticalOverFlow(verticalSize = 0){
        let htmlHeight = htmlElement().clientHeight;
        return htmlHeight < this.y + verticalSize;
    }
}

class BindValue{
    _currentValue = "";
    _bindObject = new WebObject();

    /**
     * 
     * @param {WebObject} bindObject 
     * @param {string} event 
     */
    constructor(bindObject, event){
        this._bindObject = bindObject;
        let self = this;
        bindObject.object.addEventListener(event, (e)=>{
            self._currentValue = self._bindObject.innerText;
        });
    }

    set value(newValue){
        if(this._currentValue !== newValue){
            this.bindObject.value = newValue;
            this._currentValue = newValue;
        }
    }
    get value(){
        return this._currentValue;
    }

    get bindObject(){
        return this._bindObject;
    }
}

class MenuItem {
    /**
     * 
     * @param {WebObject} webObject 
     */
    constructor(webObject){
        this.webObject = webObject;
        this.value = '';
        this.onClickEvent= ()=>{};
    }

    get value(){
        return this.webObject.value;
    }

    set value(value){
        this.webObject.value = value;
    }

    set onClickEvent(func){
        return this.webObject.object.addEventListener(MouseEventEnum.CLICK, (e)=>{func(e)});
    }
}

/**
 * @abstract
 */
class WebObject{
    _obj = undefined;
    constructor(){
        this._obj = document.createElement(this.tagName);
        let self = this;
        let hint = document.createElement('p');
        this.object.addEventListener(MouseEventEnum.OVER, (e)=>{
            let hintText = self.object.getAttribute('hint');
            if(hintText === null){
                return;
            }
            hint.classList.add('hint-box');
            hint.innerText = hintText;
            document.body.appendChild(hint);
            let displayPoint = new DisplayPoint();
            displayPoint.x = e.pageX;
            displayPoint.y = e.pageY;
            if(displayPoint.isHorizontalOverFlow(hint.clientWidth)){
                displayPoint.x = displayPoint.x - hint.clientWidth;
            }
            if(displayPoint.isVerticalOverFlow(hint.clientHeight)){
                displayPoint.y = displayPoint.y - hint.clientHeight;
            }

            hint.style.left = displayPoint.x+'px';
            hint.style.top = displayPoint.y+'px';

            e.stopPropagation();

        }, true);

        this.object.addEventListener(MouseEventEnum.MOUSE_MOVE, (e)=>{
            
            if(hint.parentNode === null){
                return;
            }
            let displayPoint = new DisplayPoint();
            displayPoint.x = e.pageX;
            displayPoint.y = e.pageY;
            if(displayPoint.isHorizontalOverFlow(hint.clientWidth)){
                displayPoint.x = displayPoint.x - hint.clientWidth;
            }
            if(displayPoint.isVerticalOverFlow(hint.clientHeight)){
                displayPoint.y = displayPoint.y - hint.clientHeight;
            } else {
                displayPoint.y+=10;
            }

            hint.style.left = displayPoint.x+'px';
            hint.style.top = displayPoint.y+'px';
            let hintText = self.object.getAttribute('hint');
            if(hintText === null){
                return;
            }
            if(hint.innerText !== hintText){
                hint.innerText = hintText;
            }
        });
        
        this.object.addEventListener(MouseEventEnum.OUT, (e)=>{
            if(hint.parentNode != null){
                hint.parentNode.removeChild(hint);
            }
        });
    }

    /**
     * object tag name
     */
    get tagName(){
        return undefined;
    }
    
    /**
     * remove this element
     */
    destory(viewTime = 0){
        setTimeout(()=>{
            this.object.parentNode.removeChild(this.object);
        }, viewTime);
    }

    /**
     * remove child all
     */
    removeAll(){
        while(this.object.lastChild){
            this.object.removeChild(this.object.lastChild);
        }
    }


    /**
     * @returns {HTMLElement}
     */
    get object(){
        return this._obj;
    }
    
    set value(str){
        this.object.innerText = str;
    }
    
    get value(){
        return this.object.innerText;
    }
}

class PObject extends WebObject{
    get tagName(){
        return 'p';
    }
}

class InputObject extends WebObject{
    
    constructor(){
        super();
        super.object.type = this.type;
    }

    get tagName(){
        return 'input';
    }
    
    get type(){
        return 'text';
    }

    set value(value){
        this.object.value = value;
    }
    
    get value(){
        return this.object.value;
    }
}

class ButtonObject extends InputObject{

    get type(){
        return 'button';
    }
}

class DivObject extends WebObject{

    get tagName(){
        return 'div';
    }
}

class ComboBoxObject extends WebObject{

    /**
     * @type {List<OptionObject>}
     */
    optionList = new List();

    constructor(){
        super();
        this.object.size = this.SIZE;
    }

    get tagName(){
        return 'select';
    }

    /**
     * record size
     */
    get SIZE(){
        return 1;
    }

    /**
     * selection index
     * @param {Number} index
     */
    set value(index){
        this.optionList.get(index).object.selected = true;
    }

    get value(){
        this.optionList.gets().forEach((element)=>{
            if(element.object.selected){
                return element.value;
            }
        });
        return undefined;
    }

    /**
     * 
     * @param {Number} value 
     * @param {String} displayName 
     */
    addOption(value, displayName){
        const option = new OptionObject();
        option.value = value;
        option.displayName = displayName;
        this.optionList.add(option);
        this.object.appendChild(option.object);
    }

    removeOption(index){
        this.optionList.get(index).destory();
        this.optionList.remove(index);
    }
}

/**
 * inner class
 */
class OptionObject extends WebObject{
    
    get tagName(){
        return 'option';
    }

    set value(index){
        this.object.value = index;
    }

    get value(){
        return this.object.value;
    }

    set displayName(string){
        this.object.label = string;
        this.object.innerText = string;
    }
    get displayName(){
        return this.object.innerText;
    }
}

class MessageWindow extends DivObject{
    _messageElement = undefined;
    constructor(){
        super();
        this.closeEvent = new List();
        this._messageElement = new PObject();
        this.object.classList.add('message-box');
        this.createBlock();
    }

    set value(message){
        this._messageElement.value = message;
    }

    get value(){
        return this._messageElement.value;
    }

    /**
     * @private
     * @param {string} message 
     */
    createBlock(message = ''){
        fixed.appendChild(this.object);
        this._messageElement.value = message;
        this.object.appendChild(this._messageElement.object);
        return this;
    }
    /**
     * close window
     * @param {Number} viewTime 
     */
    close(viewTime = 0){
        let instance = this;
        setTimeout(()=>{
            instance.object.classList.add('height-hide');
            for (const func of instance.closeEvent) {
                if(typeof(func) == "function"){
                    func();
                }
            }
            instance.destory(300);
        },viewTime);
    }


    addCloseEvent(func){
        if(typeof(func) == 'function') return;
        this.closeEvent.add(func);
    }
}

class MessageButtonWindow extends MessageWindow {
    _buttonNameList = undefined;
    constructor(){
        super();
        this._buttonNameList = new List();
        this.buttonFrame = new DivObject();
        this.createButtonBlock();
        this.object.appendChild(this.buttonFrame.object);
    }

    /**
     * @private
     */
    createButtonBlock(){
        this.changeButtonList();
        this._buttonNameList.changeEvent(()=>{this.changeButtonList();});
        return this.buttonFrame;
    }

    /**
     * @private
     */
    changeButtonList(){
        this.buttonFrame.removeAll();
        for (const buttonName of this._buttonNameList) {
            this.addButton(buttonName);
        }
    }

    /**
     * @param {MenuItem} menuitem
     */
    addButton(menuItem){
        if(menuItem === undefined) return;
        this.buttonFrame.object.appendChild(menuItem.webObject.object);
    }

    /**
     * 
     * @param {String} value 
     * @param {Function} onclick 
     */
    addItem(value, onclick){
        let menuItem = new MenuItem(new ButtonObject());
        menuItem.value = value;
        menuItem.onClickEvent = onclick;
        this._buttonNameList.add(menuItem);
    }
}
