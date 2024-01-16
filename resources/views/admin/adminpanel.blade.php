@extends('admin.layout')

@section('title', 'Home')

@section('content')

    <main class="page-content" style="margin-top: 75px;">
        <h2 class="title" style="text-align: center">
            Email Data
        </h2>
        <form class='container' autocomplete="off">
            <div class='row'>
                <div class='col-xs-6 col-sm-6 col-md-4'>
                    <div class="search-form display-flex admin-search-form">
                        <span class="form-label">First Name:&nbsp;</span>
                        <input type="search" class="search-field" value="" role="presentation" autocomplete="off"
                            name="first_name" />
                    </div>
                </div>
                <div class='col-xs-6 col-sm-6 col-md-4'>
                    <div class="search-form display-flex admin-search-form">
                        <span class="form-label">Last Name:&nbsp;</span>
                        <input type="search" class="search-field" value="" role="presentation" autocomplete="off"
                            name="last_name" />
                    </div>
                </div>
                <div class='col-xs-6 col-sm-6 col-md-4'>
                    <div class="search-form display-flex admin-search-form">
                        <span class="form-label">Email:&nbsp;</span>
                        <input type="search" class="search-field" value="" role="presentation" autocomplete="off"
                            name="email" />
                    </div>
                </div>
                <div class='col-xs-6 col-sm-6 col-md-4'>
                    <div class="search-form display-flex admin-search-form">
                        <span class="form-label">Title:&nbsp;</span>
                        <input type="search" class="search-field" value="" role="presentation" autocomplete="off"
                            name="title" />
                    </div>
                </div>
                <div class='col-xs-6 col-sm-6 col-md-4'>
                    <div class="search-form display-flex admin-search-form">
                        <span class="form-label">Company:&nbsp;</span>
                        <input type="search" class="search-field" value="" role="presentation" autocomplete="off"
                            name="company" />
                    </div>
                </div>
                <div class='col-xs-6 col-sm-6 col-md-4'>
                    <div class="search-form display-flex admin-search-form">
                        <span class="form-label">Domain:&nbsp;</span>
                        <input type="search" class="search-field" value="" role="presentation" autocomplete="off"
                            name="domain" />
                    </div>
                </div>
                <div class='col-xs-6 col-sm-6 col-md-4'>
                    <div class="search-form display-flex admin-search-form">
                        <span class="form-label">City:&nbsp;</span>
                        <input type="search" class="search-field" value="" role="presentation" autocomplete="off"
                            name="city" />
                    </div>
                </div>
                <div class='col-xs-6 col-sm-6 col-md-4'>
                    <div class="search-form display-flex admin-search-form">
                        <span class="form-label">State:&nbsp;</span>
                        <input type="search" class="search-field" value="" role="presentation" autocomplete="off"
                            name="state" />
                    </div>
                </div>
                <div class='col-xs-6 col-sm-6 col-md-4'>
                    <div class="search-form display-flex admin-search-form">
                        <span class="form-label">Country:&nbsp;</span>
                        <input type="search" class="search-field" value="" role="presentation" autocomplete="off"
                            name="country" />
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-12">
                <div class="popular-searches btn-container text-left" style="margin-top: 10px; margin-bottom: 0px;">
                    <a class="iq-button btn-radius" href="javascript:searchCriteria()"><span>Search</span></a>
                </div>
            </div>
        </div>
        <section id="sectionSrchResult" class="overview-block-ptb" style="padding: 10px 0px; min-height: 300px; margin-bottom: 150px">
            <img src="images/fancybox/overlay-dot2.png" class="overlay-right-top-2" alt="#">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="text-left iq-title-box pr-lg-5" style="margin-bottom: 5px;">
                            <h2 class="iq-title text-uppercase">Search Result<span style="font-size: 26px; margin-left: 10px;" id="spanTotal"></span></h2>
                            <p class="iq-line three"></p>
                        </div>
                    </div>
                    {{-- <div class="col-lg-3 col-md-4" style="display: flex !important; justify-content: end;">
                        <div id="btnUploadCsv" class="btn-container">
                            <a class="iq-button d-inline-block" href="javascript:upload()"
                                style="display: flex !important;padding-right: 10px; align-items: center; padding: 10px 20px;justify-content: center;">
                                <span style="font-size: 18px;">Upload CSV</span><i class="fa fa-file-text-o"
                                    style="margin-top: -5px; margin-left: 5px;"></i>
                            </a>
                        </div>
                    </div> --}}
                </div>
                <div class="row justify-content-sm-center">
                    <div class="col-sm-12" style="overflow-x: auto">
                        <table style="z-index: 2">
                            <thead>
                                <tr style="background: rgb(199, 199, 199)">
                                    <th style="min-width: 180px;">Full Name</th>
                                    <th style="min-width: 200px;">Position</th>
                                    <th style="min-width: 200px;">Company</th>
                                    <th style="min-width: 250px;">Contact</th>
                                    <th style="min-width: 150px;">City</th>
                                    <th style="min-width: 150px;">State</th>
                                    <th style="min-width: 150px;">Country</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyResult">

                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 text-center">
                        <ul class="page-numbers" id="pagination">
                         </ul>
                    </div>
                </div>
            </div>
            <img src="images/fancybox/overlay.png" class="overlay-left-bottom" alt="#" style="z-index: -1">
        </section>



    </main>

    <script>
        const url = "{{ route('api.marketings.admin_search') }}";
        let lastQuery = '';
        let curPage = 1;
        function download() {
            if (lastQuery) {
                var link = document.createElement("a");
                link.href = "{{ route('marketings.admin_download') }}" + "?criteria=" + lastQuery;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                delete link;
            }
        }
        function searchCriteria() {
            $('#preloader').show();
            $('#pagination').html('');
            $('#spanTotal').html('');
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    first_name: $('input[name="first_name"]').val(),
                    last_name: $('input[name="last_name"]').val(),
                    email: $('input[name="addr_email"]').val(),
                    title: $('input[name="title"]').val(),
                    company: $('input[name="company"]').val(),
                    domain: $('input[name="domain"]').val(),
                    city: $('input[name="city"]').val(),
                    state: $('input[name="state"]').val(),
                    country: $('input[name="country"]').val(),
                    page: curPage,
                    perPage: 20,
                },
                success: function(res) {
                    $('#preloader').hide();
                    if (!res.code) {
                        $('#sectionSrchResult').show();
                        $('#tbodyResult').html('');
                        if (res?.data?.length > 0) {
                            res?.data.forEach(function(item) {
                                let tagRes = '<tr>';
                                tagRes += '<td class="result-detail text-left">' + item.first_name +
                                    ' ' + item.last_name + '</td>';
                                tagRes += '<td class="result-detail">' + item.title + '</td>';
                                const domain = item.domain.startsWith('http') ? item.domain :
                                    'https://' + item.domain
                                let domainUrl = '<br><a href="' + domain + '" target="_blank">' + item
                                    .domain + '</a>';
                                tagRes += '<td class="result-detail">' + item.company + domainUrl +
                                    '</td>';
                                const email =
                                    '<i class="ion-ios-email" style="vertical-align: middle; font-size: 20px;"></i> : <a class="email-link" style="line-break: anywhere" href="mailto:' +
                                    item.email + '">' + item.email + '</a>';;
                                const linkedin =
                                    '<br><i class="ion-social-linkedin" style="vertical-align: middle; font-size: 20px;"></i> : <a class="email-link" href="' +
                                    item.linkedin_url + '">LinkedIn</a>';
                                tagRes += '<td class="result-detail text-left">' + email + linkedin +
                                    '</td>';
                                tagRes += '<td class="result-detail">' + item.city + '</td>';
                                tagRes += '<td class="result-detail">' + item.state + '</td>';
                                tagRes += '<td class="result-detail">' + item.country + '</td>';
                                tagRes += '</tr>';
                                $('#tbodyResult').append($(tagRes));
                            });
                            if(res.total > res.per_page) {
                                const pageTags = getPagination(res);
                                $('#pagination').html(pageTags);
                                $('#pagination li').off('click');
                                $('#pagination li').click(function() {
                                    curPage = $(this).attr('pageNum');
                                    searchCriteria();
                                })
                            }
                            $('#spanTotal').html(' (Total: ' + res.total + ')');
                        } else {
                            let tagRes = '<tr><td colspan=5 class="no-result-found">No Result Found</td></tr>';
                            $('#tbodyResult').append($(tagRes));
                        }
                    } else {
                        toastMessage('error', res.message ?? 'An error occured while searching data');
                    }

                },
                error: function(msg) {
                    $('#preloader').hide();
                    $('#tbodyResult').html('');
                    let tagRes = '<tr><td colspan=5 class="no-result-found">No Result Found</td></tr>';
                    $('#tbodyResult').append($(tagRes));
                    toastMessage('error', msg.message ?? 'An error occured while searching data');
                    console.log(msg);
                }
            });
        }
        $('.search-field').on('keydown', function(e) {
            if (e.keyCode == 13) {
                searchCriteria();
            }
        });
        $('#btnSearch').click(function() {
            searchCriteria();
        })
        $('form').on('keypress', function(e) {
            var key = e.charCode || e.keyCode || 0;
            if (key == 13) {
                e.preventDefault();
            }
        });
        searchCriteria();
    </script>
@endsection
