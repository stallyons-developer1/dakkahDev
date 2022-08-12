<template>
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $route.name | translate}}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-sm-left">
                            <li class=""><a href="#">{{ 'Home' | translate}} / </a></li>
                            <li class=" active"> {{ $route.name | translate}} </li>
                        </ul>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
</template>

<script>
    export default {
        name: "HeaderContent"
    }
</script>

<style scoped>

</style>
