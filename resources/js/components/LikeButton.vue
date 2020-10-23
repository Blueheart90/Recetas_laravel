<template>
    <div>
        <span class="like-btn" @click="likeReceta" :class="{ 'like-active' : isActive }"></span>
        <p>A <span class="font-weight-bolder text-primary" >{{ cantidadLikes }} </span>les gustó esta receta</p>
    </div>
</template>
<script>
    export default {
        props: ['recetaId', 'like', 'likes'],
        data() {
            return {
                isActive: this.like,
                totalLikes: this.likes
            }
        },
        methods: {
            likeReceta() {
                axios.post('/recetas/' + this.recetaId)
                    .then(respuesta => {
                        // console.log(respuesta);
                        if (respuesta.data.attached.length > 0 ) {
                            this.$data.totalLikes++;
                        } else {
                            this.$data.totalLikes--;
                        }
                        this.isActive = !this.isActive
                    })
                    .catch(error => {
                        // console.log(error)
                        if (error.response.status === 401) {
                            this.$swal({
                                // position: 'bottom-start',
                                position: 'bottom-start',
                                padding: '0.9rem',
                                background: '#f9d6d5',
                                html: '<div class=" alert-danger">Tienes que iniciar sesion para guardar esta receta en favoritos</div>',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInUp'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutDown'
                                },
                                showConfirmButton: false,
                                timer: 3500,

                            });
                            // Quita el 'like' de la receta visualmente
                            this.$el.firstChild.classList.remove("like-active");

                        }

                    });
            }
        },
        computed: {
            cantidadLikes: function() {
                return this.totalLikes
            }
        },
    }
</script>