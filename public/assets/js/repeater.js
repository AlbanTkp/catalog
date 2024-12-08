let CustomRepeater = (function() {
    let repeater
    let params

    function initDom() {
        let rows = $(repeater.container).find(repeater.row_class).toArray()
        rows.forEach(r_row => {
            let n_row = $(document.createElement('div'))
            n_row.addClass('row ' + repeater.row)

            $(r_row).addClass('col-' + (repeater.withRowCount ? '10' : '11'))
            $(r_row).replaceWith(
                n_row.append($(r_row).clone().removeClass(repeater.row))
            )

            if (repeater.withRowCount) {
                n_row.prepend(
                    $(document.createElement('div'))
                    .addClass('col-1 text-center')
                    .append(`
                        <div class="d-flex h-100">
                            <h5 class="m-auto align-middle font-weight-bold row-count">1</h5>
                        </div>
                        `)
                )
            }

            n_row.append(
                $(document.createElement('div'))
                .addClass('col-1 text-center')
                .append(`
                <div class="btn-ctn h-100 d-flex"></div>`)
            )
            let btn_remove = document.createElement('button')
            $(btn_remove).addClass('btn')
            $(btn_remove).attr('type', 'button')
            $(btn_remove).addClass(`btn-outline-danger ${repeater.buttons.remove} p-2 m-auto ${rows.length == 1 ? 'd-none' : 'd-flex'}`)
            $(btn_remove).html('<i class="lni lni-trash-can fw-bold  align-middle" aria-hidden="true"></i>')
            $(btn_remove).click(function(e) {
                e.preventDefault();
                removeRow(n_row)
            });
            n_row.find('.btn-ctn').append($(btn_remove))
            if (rows.slice(-1)[0] == r_row) {
                let btn_repeat = document.createElement('button')
                $(btn_repeat).addClass('btn')
                $(btn_repeat).attr('type', 'button')
                $(btn_repeat).addClass(`btn-outline-success ${repeater.buttons.repeat} m-auto`)
                $(btn_repeat).html('<i class="lni lni-circle-plus fw-bold fs-4 align-middle" aria-hidden="true"></i>')
                $(btn_repeat).click(function(e) {
                    e.preventDefault();
                    repeatRow()
                });
                n_row.after($(btn_repeat))
            }
        })
    }

    function createInstance(){
        let container = params.container
        let row = params.row || 'repeater-row'
        let withRowCount = params.withRowCount || false
        let buttons = params.buttons || {
            repeat: 'btn-repeat',
            remove: 'btn-remove'
        }
        let beforeRepeat = params.hasOwnProperty('beforeRepeat') ? params.beforeRepeat : (row) => {}
        let afterRepeat = params.hasOwnProperty('afterRepeat') ? params.afterRepeat : (row) => {}
        let beforeRemove = params.hasOwnProperty('beforeRemove') ? params.beforeRemove : (row) => {}
        let afterRemove = params.hasOwnProperty('afterRemove') ? params.afterRemove : (row) => {}

        let row_class = '.' + row
        let repeat_class = '.' + buttons.repeat
        let remove_class = '.' + buttons.remove

        return {
            container :container,
            row :row,
            withRowCount :withRowCount,
            buttons :buttons,
            beforeRepeat :beforeRepeat,
            afterRepeat :afterRepeat,
            beforeRemove :beforeRemove,
            afterRemove :afterRemove,
            row_class :row_class,
            repeat_class :repeat_class,
            remove_class :remove_class,
            destroy: destroy,
            reset: function(){
                destroy()
                init(params)
            }
        }
    }

    function repeatRow() {
        let old_row = $(repeater.row_class+':last')
        repeater.beforeRepeat()
        let new_row = old_row.clone()
        new_row.find('input').val('')
        new_row.find('select').val('')
        new_row.find('.reset-repeated').text('')
        new_row.hide(0)
        old_row.after(new_row)
        new_row.slideDown();
        $(new_row).find(repeater.remove_class).click(function(e) {
            e.preventDefault();
            removeRow(new_row)
        });
        if (repeater.withRowCount) refreshRowCount()
        refreshButtons()
        repeater.afterRepeat(new_row)
    }

    function refreshButtons(){
        if ($(repeater.remove_class).length == 1 ){
            $(repeater.remove_class+':last').addClass('d-none').removeClass('d-flex')
        }else{
            $(repeater.remove_class).addClass('d-flex').removeClass('d-none')
        }
    }

    function removeRow(parent) {
        // e.preventDefault();
        repeater.beforeRemove()
        parent.slideUp()
        setTimeout(() => {
            parent.remove()
            refreshButtons()
            if (repeater.withRowCount) refreshRowCount()
            repeater.afterRemove(parent)
        }, 500);
    }

    function refreshRowCount() {
        let i = 1
        $(repeater.container).find(repeater.row_class).toArray().forEach(row => {
            $(row).find('.row-count').text(i++)
        });
    }

    function init(_params) {
        params = _params
        repeater = createInstance()
        initDom()
        return repeater
    }

    function destroy(){
        repeater = undefined
    }

    return {
        init: init
    }
})()
