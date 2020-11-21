jQuery.fn.numeric = function(a, b) {
    a = a || ".";
    b = typeof b == "function" ? b : function() {};
    this.keypress(function(f) {
        var c = f.charCode ? f.charCode : f.keyCode ? f.keyCode : 0;
        if (c == 13 && this.nodeName.toLowerCase() == "input") {
            return true
        } else {
            if (c == 13) {
                return false
            }
        }
        var d = false;
        if ((f.ctrlKey && c == 97) || (f.ctrlKey && c == 65)) {
            return true
        }
        if ((f.ctrlKey && c == 120) || (f.ctrlKey && c == 88)) {
            return true
        }
        if ((f.ctrlKey && c == 99) || (f.ctrlKey && c == 67)) {
            return true
        }
        if ((f.ctrlKey && c == 122) || (f.ctrlKey && c == 90)) {
            return true
        }
        if ((f.ctrlKey && c == 118) || (f.ctrlKey && c == 86) || (f.shiftKey && c == 45)) {
            return true
        }
        if (c < 48 || c > 57) {
            if (c == 45 && this.value.length == 0) {
                return true
            }
            if (c == a.charCodeAt(0) && this.value.indexOf(a) != -1) {
                d = false
            }
            if (c != 8 && c != 9 && c != 13 && c != 35 && c != 36 && c != 37 && c != 39 && c != 46) {
                d = false
            } else {
                if (typeof f.charCode != "undefined") {
                    if (f.keyCode == f.which && f.which != 0) {
                        d = true
                    } else {
                        if (f.keyCode != 0 && f.charCode == 0 && f.which == 0) {
                            d = true
                        }
                    }
                }
            }
            if (c == a.charCodeAt(0) && this.value.indexOf(a) == -1) {
                d = true
            }
        } else {
            d = true
        }
        return d
    }).blur(function() {
        var d = jQuery(this).val();
        if (d != "") {
            var c = new RegExp("^\\d+$|\\d*" + a + "\\d+");
            if (!c.exec(d)) {
                b.apply(this)
            }
        }
    });
    return this
};
