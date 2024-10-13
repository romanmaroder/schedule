/**
 * Override the default yii confirm dialog. This function is
 * called by yii when a confirmation is requested.
 *
 * @param string message the message to display
 * @param string ok callback triggered when confirmation is true
 * @param string cancelCallback callback triggered when cancelled
 */


yii.confirm = function (message, okCallback, cancelCallback) {


    Swal.fire({
        title: message,
        text: "Вы не сможете отменить это действие!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Да, удалите!',
        cancelButtonText: 'Отмена!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Удалено!',
                text: 'Ваш файл удален.',
                icon: 'success',
                showCancelButton: false,
            });
            okCallback();
        }
        if (result.isDismissed) {

            cancelCallback();
        }
    })
};

    /*yii.confirm = function (message, okCallback, cancelCallback) {


        Swal.fire({
            title: message,
            text: "You will not be able to undo this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Your file has been deleted.',
                    icon: 'success',
                    showCancelButton: false,
                });
                okCallback();
            }
            if (result.isDismissed) {

                cancelCallback();
            }
        })
    };*/
