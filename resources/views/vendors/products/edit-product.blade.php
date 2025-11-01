@extends('vendors.vendor-masters')

@section('vendor')
    <link rel="stylesheet" href="{{ asset('vendors/assets/css/edit.css') }}" />

    <div class="loader-overlay" id="loaderOverlay" style="display: none;">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <p>Updating product...</p>
        </div>
    </div>

    <main class="container2">
        <div class="top-bar">
            <div class="icon">
               <a href="{{route ('vendor.dashboard')}}">
                    <svg width="31" height="30" viewBox="0 0 31 30" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect y="0.5" width="31" height="29" rx="5" fill="rgba(255,255,255,0.2)" />
                        <path d="M21.0404 15H9.95703" stroke="white" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M15.4987 20.5423L9.95703 15.0007L15.4987 9.45898" stroke="white" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
            <div class="add-product">
                <h2>Update Product</h2>
            </div>
        </div>

        <div class="form-section">
            <form action="{{ route('vendor.update.product') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">


                <div class="img-upload">
                    <div class="img">
                        <label for="image">
                            <img src="{{ asset('uploads/no_image.jpg') }}" alt="" id="showImage"
                                style="width:150px;height:137px;object-fit:cover;object-position:top;">
                        </label>
                        <p id="noOfFiles"></p>
                    </div>
                    <input type="file" id="image" name="images[]" multiple hidden>
                    <input type="hidden" id="ai_caption" name="ai_caption">
                    <input type="hidden" id="ai_category_id" name="ai_category_id">
                    <input type="hidden" id="use_ai_suggestions" name="use_ai_suggestions" value="0">

                    <div class="showPrevImages" id="sortable">
                        @foreach ($product->getImage as $image)
                            @if (!empty($image->getAllImages()))
                                <div class="prevImage sortable_image" id="{{ $image->id }}">
                                    <img style="width: 60px; height:60px;display:block;" src="{{ $image->getAllImages() }}"
                                        alt="Product Images">
                                    <a href="{{ route('vendor.image_delete', $image->id) }}" class="deleteSizeNow"
                                        id="delete">Delete </a>
                                </div>
                            @endif
                        @endforeach

                    </div>


                    <p class="img-description">You can drag the Image that you want to have in front</p>
                    <p class="img-description">(Recommended Dimension: 930^1163)</p>
                    <span class="errors"></span>
                </div>

                <div class="ai-suggestions" id="ai-suggestions">
                    <h4 style="margin-bottom: 15px; color: var(--purple);">🤖 AI Product Suggestions</h4>
                    <div class="ai-loading" id="ai-loading">
                        <div
                            style="display: inline-block; width: 20px; height: 20px; border: 3px solid #f3f3f3; border-top: 3px solid var(--purple); border-radius: 50%; animation: spin 1s linear infinite;">
                        </div>
                        <p>Analyzing your product image...</p>
                    </div>
                    <div id="ai-suggestions-list"></div>
                    <div class="ai-error" id="ai-error"></div>
                </div>

                <div class="form-contain">
                    <label class="form-label">Product Name*</label>
                    <div class="form-input">
                        <input type="text" name="product_name" placeholder="Enter Product Name *" class="form-control"
                            id="product_name" value="{{ $product->product_name ?? '' }}">
                    </div>
                    <p class="errors"></p>
                </div>

                <div id="ai-price-loading" class="loading" style="display:none;">
                    <div class="spinner"></div>
                    Fetching AI price suggestion...
                </div>

                <div class="suggestions">
                    <div id="ai-price-suggestions-list"></div>
                    <div id="ai-price-error" class="price-error"></div>
                    <button type="button" id="clear-suggestion">Clear Results</button>
                </div>

                <div class="form-contain">
                    <label class="form-label">
                        Price*
                        <span class="material-symbols-outlined" title="How much the product costs"
                            style="font-size:16px; vertical-align:middle;">
                            info
                        </span>
                    </label>

                    <div class="form-input">
                        <input type="text" name="new_price" placeholder="Enter Price *" class="form-control digits"
                            id="price" value="{{ $product->new_price }}">
                    </div>
                    <p class="errors"></p>
                </div>

                <div class="form-contain">
                    <div class="form-inputs">
                        <input type="checkbox" name="cPrice" id="cPrice" checked>
                        <label for="cPrice">Add Cost Price
                            <span class="material-symbols-outlined" title="The price you bought the product for"
                                style="font-size:16px; vertical-align:middle;">
                                info
                            </span>
                        </label>
                    </div>
                </div>

                <div class="form-input showToggle" style="display: block;">
                    <input type="text" name="old_price" value="{{ $product->old_price }}" class="form-control digits"
                        id="old_price">
                </div>

                <div class="form-contain">
                    <label class="form-label">Description*</label>
                    <div class="form-input form-text-area">
                        <textarea name="description" rows="10" class="form-controls" id="description"
                            placeholder="Enter Product Description *" style="resize:none">{{ $product->description }}</textarea>
                        <div class="speech">
                            <button type="button" id="startBtn" title="Start Recording" class="record-btn">
                                <span class="material-symbols-outlined"
                                    style="font-size:22px; vertical-align:middle;color:white;">
                                    mic
                                </span>
                            </button>

                            <button type="button" id="stopBtn" title="Stop Recording" style="display:none;">
                                <svg viewBox="0 0 24 24">
                                    <rect x="6" y="6" width="12" height="12" rx="2" ry="2" />
                                </svg>
                            </button>
                            <span id="listening"></span>
                        </div>
                    </div>
                    <p class="errors"></p>
                </div>

                <div class="flex-form">
                    <div>
                        <label class="form-label">Stock quantity*</label>
                        <input type="number" id="stock_quantity" name="stock_quantity"
                            value="{{ $product->stock_quantity ?? 0 }}" class="form-select digits" />
                    </div>
                    <div>
                        <label class="form-label">Unit*</label>
                        <select name="unit" id="unit" class="form-select form-selects">
                            <option value="" disabled>Select Unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->unit }}"
                                    {{ $product->unit == $unit->unit ? 'selected' : '' }}>
                                    {{ $unit->unit }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <p class="errors"></p>

                <div class="form-contain">
                    <label class="form-label">Choose category*</label>
                    <div class="form-input">
                        <select name="category_id" class="form-control" id="category_id">
                            <option value="" disabled>Select Product Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="errors"></p>
                </div>

                <div class="form-contain">
                    <label class="form-label">Select a Location*</label>
                    <div class="form-input">
                        <select name="location" id="location" class="form-control">
                            <option value="" disabled>Select Product Location</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->name }}"
                                    {{ $product->location == $location->name ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <p class="errors"></p>
                </div>

                <div class="form-contain">
                    <label class="form-label">City</label>
                    <div class="form-input">
                        <input type="text" name="city" value="{{ $product->city }}" class="form-control"
                            id="city">
                    </div>
                </div>

                <div class="form-contain">
                    <label class="form-label">Tags</label>
                    <div class="form-input" style="margin-top: 20px;">
                        <input type="text" name="tags" id="tags" data-role="tagsinput"
                            class="bootstrap-tagsinput" value="{{ implode(',', $product->tags ?? []) }}" />
                    </div>
                </div>


                <div class="form-contain">
                    <label class="form-label">Select Colors</label>
                    <div class="form-input colors">
                        <label>Select Colors for this Product</label>
                        <div class="flex-size">
                            @foreach ($colors as $color)
                                @php
                                    $checked = '';
                                @endphp

                                @foreach ($product->getColor as $pColor)
                                    @if ($pColor->color_id == $color->id)
                                        @php
                                            $checked = 'checked';
                                        @endphp
                                    @endif
                                @endforeach

                                <label class="form-label">
                                    <input type="checkbox" name="color_id[]" value="{{ $color->id }}"
                                        {{ $checked }}>
                                    {{ $color->color }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>



                <div class="form-contain">
                    <label class="form-label">Custom sizes</label>
                    <div class="form-input">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Size</th>
                                    <th colspan="2">Price (₦)</th>
                                </tr>
                                <tbody id="appendSize">
                                    @php
                                        $i = 1;
                                    @endphp

                                    @foreach ($product->getSize as $size)
                                        <tr id="deleteSize{{ $i }}">
                                            <td>
                                                <input type="text" value="{{ $size->name }}" placeholder="Name"
                                                    name="size[{{ $i }}][name]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" value="{{ $size->price }}" placeholder="Price"
                                                    name="size[{{ $i }}][price]" class="form-control">
                                            </td>
                                            <td style="width: 40px">
                                                <button type="button" id="{{ $i }}"
                                                    class="btn btn-danger deleteSize">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach



                                    <tr>
                                        <td>
                                            <input type="text" name="size[100][name]" placeholder="Eg Small, Medium"
                                                class="form-con">
                                        </td>
                                        <td>
                                            <input type="text" name="size[100][price]" placeholder="Enter Price"
                                                class="form-con digits">
                                        </td>
                                        <td style="width:80px">
                                            <button type="button" class="addSize">Add</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-add" name="updateProduct">Update Product</button>
            </form>
        </div>
    </main>

    <!-- Success Modal Dummy -->
    <div class="containerSuccess" style="display:none;">
        <div class="success">
            <svg width="201" height="200" viewBox="0 0 157 156" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="78.5" cy="78" r="78" fill="var(--purple)" fill-opacity="0.1" />
                <path
                    d="M50 71.709C45.866 71.709 42.5 75.075 42.5 79.2089V103.209C42.5 107.343 45.866 110.709 50 110.709H59C60.689 110.709 62.2429 110.139 63.5 109.191V71.709H50Z"
                    fill="var(--purple)" />
                <path
                    d="M114.5 82.959C114.5 81.156 113.786 79.476 112.547 78.2369C113.948 76.704 114.662 74.6489 114.467 72.51C114.116 68.6969 110.681 65.7089 106.643 65.7089H88.112C89.03 62.9219 90.4999 57.813 90.4999 53.709C90.4999 47.2019 84.971 41.709 81.4999 41.709C78.383 41.709 76.1569 43.464 76.061 43.536C75.707 43.821 75.5 44.253 75.5 44.7089V54.8819L66.86 73.599L66.5 73.7819V105.936C68.942 107.088 72.0319 107.709 74 107.709H101.537C104.804 107.709 107.663 105.507 108.335 102.468C108.68 100.905 108.479 99.33 107.792 97.962C110.009 96.846 111.5 94.563 111.5 91.959C111.5 90.897 111.257 89.88 110.795 88.959C113.012 87.843 114.5 85.56 114.5 82.959Z"
                    fill="var(--purple)" />
            </svg>
            <h2>Congratulations!</h2>
            <p class="successMessage">Your Product was successfully updated</p>
            <a href="../profile/active_products.php"><button class="btn">View Product</button></a>
        </div>
    </div>








    <script src="{{ asset('vendors/assets/js/jqueryUI.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>



    <script>
        $(document).ready(function() {

            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

            $("#image").change(function(e) {

                const count = e.target.files.length;
                $('#noOfFiles').text(`Uploading ...`);

                setTimeout(() => {
                    if (count > 1) {
                        $('#noOfFiles').text(`${count} images selected`);
                    } else {
                        $('#noOfFiles').text(`${count} image selected`);
                    }
                }, 3000);

            });



            // hide or show on load
            $(".showToggle").toggle($("#cPrice").is(":checked"));

            // listen for change
            $("#cPrice").on("change", function() {
                $(".showToggle").toggle(this.checked);
            });


        });
    </script>


    <script>
        $(document).ready(function() {
            $("#sortable").sortable({
                update: function(event, ui) {
                    var photo_id = [];

                    $('.sortable_image').each(function() {
                        var id = $(this).attr('id');
                        photo_id.push(id);
                    });

                    let product_id = `{{ $product->id }}`;

                    // Show updating modal
                    $('#updatingModal').modal('show');

                    $.ajax({
                        url: `{{ route('vendor.update_image_order') }}`,
                        type: 'POST',
                        data: {
                            photo_id: photo_id,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(data) {
                            // Hide modal after success
                            $('#updatingModal').modal('hide');

                            if (data.success) {
                                toastr.success('Image order updated successfully',
                                    'Success');
                            } else {
                                toastr.warning(
                                    'Update completed, but with unexpected result',
                                    'Notice');
                            }

                            console.log("Order updated successfully:", data);
                        },
                        error: function(error) {
                            // Hide modal
                            $('#updatingModal').modal('hide');

                            toastr.error('Failed to update image order. Please try again.',
                                'Error');
                            console.error("Error updating order:", error);
                        }
                    });
                }
            });

            // Add Size
            var i = 101;
            $('.addSize').click(() => {
                let html = `<tr id="deleteSize${i}">
                      <td>
                        <input type="text" name="size[${i}][name]" placeholder="Eg Small, Medium" class="form-con">
                      </td>
                      <td>
                        <input type="text" name="size[${i}][price]" placeholder="Enter Price" class="form-con digits">
                      </td>
                      <td width='40px'>
                        <button type="button" id="${i}" class="btn btn-danger deleteSize">
                        <span class="material-symbols-outlined">delete</span>
                        </button>
                      </td>
                    </tr>`;
                i++;
                $('#appendSize').append(html);
            })


            // Use event delegation to attach the click event handler to dynamically created elements
            $(document).on('click', '.deleteSize', function() {
                var id = $(this).attr('id');
                $(`#deleteSize${id}`).remove();
            });

        });
    </script>


    <script>
        $(document).ready(function() {
            // Handle form submission
            $('form').on('submit', function(e) {
                // Show loader
                $('#loaderOverlay').show();

                // $('[name="updateProduct"]').prop('disabled', true);

                setTimeout(() => {}, 100);

            });

            $('[name="updateProduct"]').prop('disabled', false);
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.querySelectorAll('.digits').forEach(function(input) {
                input.addEventListener("input", function(e) {
                    let value = event.target.value;
                    let newValue = value.replace(/[^+0-9]/g, '');
                    if (newValue.indexOf('+') !== -1) {
                        newValue = newValue.replace(/\+/g, '');
                        newValue = '+' + newValue;
                    }
                    if (newValue.length > 14) {
                        newValue = newValue.substring(0, 14);
                    }
                    event.target.value = newValue;
                });
            })

        });
    </script>
@endsection
