if (!window.cropper) {
    window.cropper = {
        dialogues: {},
        current_dialogue: null,
        create_dialogue: function create_dialogue(elem, name){
            this.elem = elem;
            this.field_name = name;
            this.ready = false;
            this.initialising = false;
            this.init = function(){
                if (this.initialising) return false;
                this.initialising = true;
                
                this.dirs = $.parseJSON(decodeURIComponent($(this.elem).attr('rel')));
                // Тень на задний фон
                if (!this._fade) {
                    var fade = document.createElement('div');
                    fade.style.position = 'fixed';
                    fade.style.top = '0px';
                    fade.style.left = '0px';
                    fade.style.height = '100%';
                    fade.style.width = '100%';
                    fade.style.background = '#666';
                    fade.style.zIndex = '100';
                    fade.style.opacity = '0.6';
                    fade.parent_elem = this;
                    $(fade).click(function(){
                        this.parent_elem.close();
                    });
                    this._fade = fade;
                }

                // Основной див
                {
                    var div = document.createElement('div');
                    div.className = 'cropper_dialog';
                    div.style.position = 'absolute';
                    div.style.top = '200px';
                    //div.style.height = '440px';
                    //div.style.width = '830px';
                    div.style.left = $(window).width() / 2 - 415 + 'px';
                    div.style.backgroundColor = '#FFF';
                    div.style.border = '1px solid #000';
                    div.style.zIndex = '101';
                }

                // Див с исходным изображением
                {
                    var tr = this.temp_tr = document.createElement('tr');
                    var td = this.temp_td = document.createElement('td');
                    this.image_div = document.createElement('div');
                    this.image_div.style.cssFloat = 'left';
                    var self = this;
                    this.temp_div = div;
                    this.image_div.innerHTML = '<img  style="margin: 20px; max-width: 400px; max-height: 400px;" src="' + $(this.elem).attr('href') + '">';
                    $(this.image_div).find('img').bind('load', function(){
                        self.image_div.image_height = $(self.image_div).find('img').get(0).naturalHeight;
                        self.image_div.image_width = $(self.image_div).find('img').get(0).naturalWidth;
                        
                        self.temp_td.appendChild(self.image_div);
                        self.temp_tr.appendChild(td);
                        self.init2();
                    });
                }
            }
            this.init2 = function(){
                // Див с результатом
                {
                    var div = this.temp_div;
                    var td = document.createElement('td');
                    var tr = this.temp_tr;
                    td.style.verticalAlign = 'middle';
                    td.style.textAlign = 'center';
                    this.dislike = document.createElement('button');
                    this.dislike.style.margin = 'auto';
                    this.dislike.style.cursor = 'pointer';
                    this.dislike.innerHTML = 'Мне не нравится';
                    $(this.dislike).click(function(){
                        var cur_cropper = window.cropper.current_dialogue;
                        cur_cropper.image_area_select = $(cur_cropper.image_div).find('img').imgAreaSelect(cur_cropper.tab.options);
                        cur_cropper.resize();
                        $(cur_cropper.result_div.image_elem).attr('src', $(cur_cropper.elem).attr('href'));
                        cur_cropper.confirm_button.style.display = 'block';
                        this.style.display = 'none';
                    });

                    this.result_div = document.createElement('div');
                    this.result_div.style.cssFloat = 'left';
                    this.result_div.style.overflow = 'hidden';
                    this.result_div.style.margin = '20px';
                    this.result_div.innerHTML = '<img  class="cropper_result_image" style="position: relative;" src="' + $(this.elem).attr('href') + '">';
                    this.result_div.image_elem = $(this.result_div).find('img').get(0);
                    td.appendChild(this.result_div);
                    td.appendChild(document.createElement('br'));
                    td.appendChild(this.dislike);
                    td.appendChild(document.createElement('br'));
                    tr.appendChild(td);
                }

                // Див с меню
                {
                    this.menu_div = document.createElement('div');
                    this.menu_div.style.width = '100%';
                    this.menu_div.style.cssFloat = 'right';
                    this.menu_div.style.borderBottom = '1px #000 solid';
                    this.menu_div.directories = new Object();

                    var first = true;
                    var prev = null;
                    for (prop in this.dirs) {
                        if (!this.dirs.hasOwnProperty(prop)) continue;

                        this.dirs[prop].options = {
                            instance: true,
                            imageHeight: this.image_div.image_height,
                            imageWidth: this.image_div.image_width,
                            x1: 0, y1: 0,
                            persistent: true,
                            onSelectChange: function(img, opt) {
                                window.cropper.current_dialogue.resize(opt);
                            }
                        }
                        switch (this.dirs[prop].ratio) {
                            case 'max':
                            case 'x':
                            case 'y':
                            case 'equal':
                                var rate_y = this.image_div.image_height / this.dirs[prop].h;
                                var rate_x = this.image_div.image_width / this.dirs[prop].w;
                                if (rate_x > rate_y) var rate = rate_y;
                                else var rate = rate_x;
                                if (rate <= 1) {
                                    delete this.dirs[prop];
                                    continue;
                                } else {
                                    this.dirs[prop].options.x2 = this.dirs[prop].w;
                                    this.dirs[prop].options.y2 = this.dirs[prop].h;
                                    /*this.dirs[prop].options.x2 = 162;
                                    this.dirs[prop].options.y2 = 121;*/
                                    this.dirs[prop].options.minHeight = this.dirs[prop].h;
                                    this.dirs[prop].options.minWidth = this.dirs[prop].w;
                                }
                                this.dirs[prop].options.aspectRatio = this.dirs[prop].w + ':' + this.dirs[prop].h;
                                //this.dirs[prop].options.aspectRatio = '1:1' + this.dirs[prop].h;
                            break;
                            default:
                                delete this.dirs[prop];
                                continue;
                        }

                        // Связный список вкладок
                        this.dirs[prop].prev = prev;
                        this.dirs[prop].next = null;
                        if (prev) prev.next = this.dirs[prop];
                        prev = this.dirs[prop];
                        
                        this.dirs[prop].dir_name = prop;
                        if (first && !this.tab) {
                            this.tab = this.dirs[prop];
                            first = false;
                        }
                        var menu_item = document.createElement('div');
                        $(menu_item).attr('rel', prop);
                        $(menu_item).click(function(){
                            var prop = $(this).attr('rel');
                            var cur_cropper = window.cropper.current_dialogue;
                            cur_cropper.tab = cur_cropper.dirs[prop];
                            cur_cropper.tab.dir_name = prop;
                            cur_cropper.open();
                        });
                        if (this.dirs[prop].title) {
                            menu_item.innerHTML = this.dirs[prop].title;
                            menu_item.style.padding = '5px';
                            menu_item.style.display = 'block';
                            menu_item.style.cssFloat = 'left';
                            menu_item.style.cursor = 'pointer';
                            this.menu_div.directories[prop] = menu_item;
                            this.menu_div.appendChild(menu_item);
                        }
                    }
                }

                div.appendChild(this.menu_div);
                var table = document.createElement('table');
                table.appendChild(tr);
                div.appendChild(table);
                this.confirm_button = document.createElement('button');
                this.confirm_button.innerHTML = 'Нужно так!';
                this.confirm_button.style.display = 'none';
                this.confirm_button.style.margin = 'auto';
                this.confirm_button.style.cursor = 'pointer';
                $(this.confirm_button).click(this.confirm);
                div.appendChild(this.confirm_button);
                div.appendChild(document.createElement('br'));
                this._cache = div;
                this._div = null;
                this.image_area_select = null;
                
                this.ready = true;
                this.initialising = false;
                this.open();
            };
            this.close = function(){
                $(this.image_div).find('img').imgAreaSelect({remove: true});
                this._div.parentNode.removeChild(this._div);
                this._div = null;
                this._fade.parentNode.removeChild(this._fade);
            };
            this.resize = function(opt){
                if (!opt) {
                    opt = this.image_area_select.getSelection();
                }
                var result = this.result_div.image_elem;
                switch (this.tab.ratio) {
                    case 'max':
                    case 'x':
                    case 'y':
                    case 'equal':
                        var rate_x = (opt.x2 - opt.x1) / this.tab.w;
                        var rate_y = (opt.y2 - opt.y1) / this.tab.h;
                        // Во сколько раз сжать (по минимуму)
                        var rate = (rate_x > rate_y) ? rate_y : rate_x;
                        if (rate < 1) rate = 1;
                        result.style.height = this.image_div.image_height / rate + 'px';
                        result.style.width = this.image_div.image_width / rate + 'px';
                        result.style.left = '-' + (opt.x1 / rate) + 'px';
                        result.style.top = '-' + (opt.y1 / rate) + 'px';
                    break;
                    default:
                        return false;
                }
            };
            this.next_tab = function(){
                this.tab = this.tab.next;
                this.open();
            };
            this.confirm = function(){
                var data = {};
                var cur_cropper = window.cropper.current_dialogue;
                data.dir = cur_cropper.tab.dir_name;
                data.se_options = cur_cropper.image_area_select.getSelection();
                data.field = cur_cropper.field_name;
                $.post($(cur_cropper.elem).attr('link'), data, function(result) {
                    //window.cropper.current_dialogue.next_tab();
                    window.cropper.current_dialogue.open();
                });
            };
            this.open = function() {
                if (!this._cache) {
                    console.log('необходимо сначала инициализировать объект');
                    return false;
                }
                window.cropper.current_dialogue = this;
                this._div = this._cache;
                $(this.menu_div).find('div').css('backgroundColor', '');
                this.menu_div.directories[this.tab.dir_name].style.backgroundColor = '#999';
                $('body').append(this._fade);
                $('body').append(this._div);

                //this.image_area_select = $(this.image_div).find('img').imgAreaSelect(this.tab.options);
                if (this.image_area_select) {
                    this.image_area_select = $(this.image_div).find('img').imgAreaSelect({remove: true});
                }
                this.confirm_button.style.display = 'none';
                $(this.result_div.image_elem).attr('src', $(this.elem).attr('href').replace('original', this.tab.dir_name)+'?'+(new Date()).getTime());
                this.dislike.style.display = 'block';
                this.result_div.image_elem.style.left = '0px';
                this.result_div.image_elem.style.top = '0px';
                this.result_div.image_elem.style.width = this.tab.w + 'px';
                this.result_div.image_elem.style.height = this.tab.h + 'px';
                this.result_div.style.width = this.tab.w + 'px';
                this.result_div.style.height = this.tab.h + 'px';
            };
            this.is_ready = function() {
                return this.ready;
            }
        },
        show_crop_dialogue: function(elem) {
            var field = $(elem).parent().parent().find('input').attr('name');
            if (!this.dialogues[field]) {
                this.dialogues[field]= new this.create_dialogue(elem, field);
                this.dialogues[field].init();
            }
            if (this.dialogues[field].is_ready()) {
                this.dialogues[field].open();
            }
            return false;
        }
    }
}