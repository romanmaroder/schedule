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


        /*Swal.fire({
            title: message,
            text: "You will not be able to undo this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel!',
            preConfirm: async () => {
                var id = $(this).attr('data-id');
                console.log(id);
                try {
                    const deleteUrl = `http://backend.core/employee/delete?id=${id}`;
                    const response = await fetch(deleteUrl);
                    if (response.ok) {
                        return Swal.showValidationMessage(`
                                         ${JSON.stringify(await response.json())}
                                    `);
                    }
                    if (response.status) {
                        return Swal.showValidationMessage(`
                                         ${JSON.stringify(await response.json())}
                                    `);
                    }
                    return response.json();
                } catch (error) {
                    Swal.showValidationMessage(`
                       // Request failed: ${error}
                        Request failed: ${console.error(error)}
                    `);
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: `${result.value.id}'s avatar`,
                    imageUrl: result.value.avatar_url
                });
            }else{
                swal("User not deleted your user is safe!", {
                    icon: "error",
                });
            }
        })*/

    };
