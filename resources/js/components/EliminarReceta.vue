<<template>
    <div>
      <input type="submit" 
            class="btn btn-danger w-100 mb-2" 
            value="Delete"
            @click="eliminarReceta"
        />  
    </div>
</template>

<script>
export default {
    props:['recetaId'],
    methods:{
        eliminarReceta(){
            this.$swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    //parametros
                    const params = {
                        id:this.recetaId
                    }

                    //envia peticion
                    axios.post(`/recetas/${this.recetaId}`,{params,_method:'delete'})
                        .then(respuesta =>{
                            this.$swal({
                                title:'Recipe deleted',
                                text:'Recipe was deleted',
                                icon:'success'
                            });
                            //eliminar del dom
                            this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode)
                        })
                        .catch(error => {
                            console.log(error);
                        })
                
            })
        }
    }
}
</script>