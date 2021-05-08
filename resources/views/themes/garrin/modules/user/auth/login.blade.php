<div class="content">
    <div class="container-fluid bg-cover-06">
        
        <div class="row">
            <div class="col-md-8 offset-md-2 mb-5">
                
                <!-- Login  محتوای تب -->
                <div class="account-content">
                    <div class="row align-items-center justify-content-center">
                        @if ($user)
                        <livewire:auth.form-validation :view="'theme::modules.user.auth.form-validation'" :user="$user" />
                        @else
                        <livewire:auth.form-login :view="'theme::modules.user.auth.form-login'" />
                        @endif
                    </div>
                </div>
                <!-- /Login  محتوای تب -->
                    
            </div>
        </div>

    </div>
</div>	