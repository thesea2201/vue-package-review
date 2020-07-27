  <!-- File: packages/Acme/VuePageReview/resources/views/section.blade.php -->
<div class="container" id="review">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4>Add review</h4>
                    <p v-if="errors.length">
                        <b style="color: red">Please correct the following error(s):</b>
                        <ul style="color: red">
                          <li v-for="error in errors">@{{ error }}</li>
                        </ul>
                      </p>
                    <div class="form-group">
                        <input type="text" v-model="username" class="form-control col-6" placeholder="Enter your username">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" v-model="comment" placeholder="Enter your review"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" id="rcaptcha" data-sitekey="6LcNaLQZAAAAAJp3HzOutUvdrHJj_vO3VHjLslHV"></div>
                    </div>
                    
                    <div class="form-group">
                        <input type="button" v-on:click="addPageReview" v-bind:disabled="isDisabled" class="btn btn-success" value="Add Review" />
                    </div>
                    <hr />
                    <h4>Display reviews</h4>
                    <div v-for="review in reviewsPaginate">
                        <strong>@{{ review.username }}</strong><i> reviewed at @{{ review.created_at }}</i>
                        <p>@{{ review.comment }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPageReviews()"></pagination>
</div>
<!-- Add Vue Code -->
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="module" >
    console.log('section js');
    // Pusher.logToConsole = true;
    var review = new Vue({
 
        el: '#review',
        data: {
            username: null,
            comment: null,
            path: window.location.pathname,
            isDisabled: false,
            reviews: [],
            page: [],
            pagination: [],
            reviewsPaginate : [],
            errors: [],
        },
        methods: {
            subscribe() {
                // var pusher = new Pusher('{{ env('PUSHER_APP_KEY')}}', {
                //     cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                // });
                // pusher.subscribe('page-' + this.page.id)
                //     .bind('new-review', this.fetchPageReviews);
            },
            fetchPageReviews() {
                var vm = this;
                var url = '{{ route('vuepagereview.index') }}' + '?path=' + this.path + '&page=' + this.pagination.current_page;

                fetch(url)
                    .then(function(response) {
                        return response.json()
                    })
                    .then(function(json) {
                        vm.page = json.page
                        vm.reviews = json.reviews
                        vm.pagination = json.pagination
                        vm.reviewsPaginate = json.reviewsPaginate.data
                        vm.subscribe();
                    })
            },
            addPageReview(event) {
                event.preventDefault();
                if(this.checkForm() !== true){
                    return false;
                }
                if(this.get_action() !== true){
                    return false;
                }

                this.isDisabled = true;
                const token = document.head.querySelector('meta[name="csrf-token"]');
                const data = {
                    path: this.path,
                    comment: this.comment,
                    username: this.username,
                };
                fetch('{{ route('vuepagereview.store') }}', {
                    body: JSON.stringify(data),
                    credentials: 'same-origin',
                    headers: {
                        'content-type': 'application/json',
                        'x-csrf-token': token.content,
                    },
                    method: 'POST',
                    mode: 'cors',
                }).then(response => {
                    this.isDisabled = false;
                    if (response.ok) {
                        this.username = '';
                        this.comment = '';
                        this.fetchPageReviews();
                    }
                })
            },
            checkForm: function () {
                this.errors = [];

                if (!this.username) {
                    this.errors.push("Username required.");
                }
                if (!this.comment) {
                    this.errors.push('Review required.');
                }

                if (!this.errors.length) {
                    return true;
                }
            },
            get_action(form){
                var v = grecaptcha.getResponse();
                if(v.length == 0){
                    this.errors.push("Please check the reCaptcha");
                    return false;
                }
                else{
                    return true; 
                }
            }
        },
        created() {
            this.fetchPageReviews();
        },
    });
</script>