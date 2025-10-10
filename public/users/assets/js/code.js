$(function(){
    $(document).on('click','#delete',function(e){
        e.preventDefault();
        var link = $(this).attr("href");

                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete This Data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                    }
                  }) 


    });

    $(document).on('click','#restore',function(e){
        e.preventDefault();
        var link = $(this).attr("href");

                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Restore This Data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#7c3aed',
                    cancelButtonColor: '#fb7e00',
                    confirmButtonText: 'Yes, restore it!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Restored!',
                        'Your file has been Restored.',
                        'success'
                      )
                    }
                  }) 


    });

    $(document).on('click','#logout',function(e){
        e.preventDefault();
        var link = $(this).attr("href");

                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Log out from Closeseller?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#7c3aed',
                    cancelButtonColor: '#fb7e00',
                    confirmButtonText: 'Yes, logout'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Logged Out!',
                        'You have successfully logged out.',
                        'success'
                      )
                    }
                  }) 


    });

  });