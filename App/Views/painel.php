

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>


    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
          <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
          </a>
          <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
          </ul>
          <div class="col-md-3 text-end">
            <button type="button" class="btn btn-primary" id="btnSair">Sair</button>
          </div>
        </header>

        <h2 class="mt-4">Usuarios</h2>
        <div class="row mb-3 text-center">
            <div class="col-md-8 themed-grid-col" id="dados-user">
            </div>
             <div class="col-md-4 themed-grid-col">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Editar</button>

                <?php 
                    if($user['admin'] == 1){
                      echo '<button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal" >Cadastra Novo Usuario</button>';
                    }
                ?>

            </div>
        </div>

        <div class="b-example-divider"></div>

        <h2 class="mt-4">Agenda</h2>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Cafés</th>
              </tr>
            </thead>
            <tbody id="table-body">
            
            </tbody>
          </table>


        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="form-editar" action="javascript:void(0)" method="POST">
                    <div class="mb-3">
                      <label for="recipient-name" class="col-form-label">email:</label>
                      <input type="email" name="email" class="form-control" id="editarEmail">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">nome:</label>
                        <input type="text" name="name" class="form-control" id="editarName">
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">senha:</label>
                        <input type="password" name="password" class="form-control" id="editarPassword">
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  <button type="button" class="btn btn-primary" id="btn-salvar">Salvar</button>
                </div>
              </div>
            </div>
          </div>

    </div>

     <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script type="text/javascript">

        const user = {};
        const Api_url = "http://localhost/api-mosyle/public_html/api/";
        const url = "http://localhost/front-mosyle/"
        const dadosUser = document.getElementById('dados-user');
        const btnEditar = document.getElementById('btn-salvar');
        const btnSetDrink = document.getElementById('set-drink');
        const btnDelete = document.getElementById('delete-user');
        const btnSair = document.getElementById('btnSair')

       
        async function getUser(){
            try {
                    var id = document.getElementById('userId').value;
                    await fetch(`${Api_url}user/getUser/${id}`,{
                    method: "GET",
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                }).then(response => response.json())
                    .then((response) => {
                    if(response.status == "sucess"){  
                    
                         setDadosUser(response.data.user);
                         localStorage.setItem('user', JSON.stringify(response.data.user));   
                         alert('Usuario Alterado!');


                    }else{
                        console.log(response.data);
                }
                }).catch((error) => {
                    alert(error.data);
                    console.log(error);
                });
                
            } catch (error) {
                console.log(error);
            }

        }



        async function setDadosUser(user){

            dadosUser.innerHTML =`
                                <input type="hidden" name="id"  id="userId" value=${user.id}>                      
                                    <div class="pb-3">
                                            Nome : ${user.name}     
                                    </div>
                                        <div class="row">
                                            <div class="col-md-6 themed-grid-col">Email: ${user.email}</div>
                                            <div class="col-md-6 themed-grid-col">Cafés: ${user.drinkCounter}</div>
                                        </div>
                    `

            var nome = document.getElementById('editarName');
            var email = document.getElementById('editarEmail');  
            nome.value = user.name;
            email.value = user.email;
        }



        async function getUsers(){
            try {
                    
                        await fetch(`${Api_url}user/getUsers`, {
                        method: "GET",
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('token')
                        },
                    }).then(response => response.json())
                        .then((response) => {
                        if(response.status == "sucess"){  
                            
                         var tbody = document.getElementById('table-body');
                         var users =  response.data.users;
                         var html =''

                         users.forEach(element => {

                            html += `
                                    <tr>
                                        <th scope="row">${element.id}</th>
                                        <td>${element.name}</td>
                                        <td>${element.email}</td>
                                        <td>${element.drinkCounter}</td>
                                    </tr>
                              `
                         });
                        
                         tbody.innerHTML=html;

                        }else{
                            alert(response.data);
                    }
                    }).catch((error) => {
                        alert(error.data);
                        console.log(error);
                    });
                    
                } catch (error) {
                    console.log(error);
                }

        }

        btnEditar.onclick = async function(){

            var nome = document.getElementById('editarName');
            var email = document.getElementById('editarEmail');
            var password = document.getElementById('editarPassword');
            var confirmPassword = document.getElementById('confirmPassword');

            if(nome.value =="" || email.value == ""){

                    return  alert('É nescessario informar todos os dados!');
                }else{
                      await sendEditar();
                }
         }


         async function sendEditar(){

            try {
                   var data = new FormData(document.getElementById('form-editar'));

                   var id = document.getElementById('userId').value;

                    await fetch(`${Api_url}user/update/${id}`, {
                    method: "POST",
                    body: data,
                    headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                }).then(response => response.json())
                    .then((response) => {
                        if(response.status == "sucess"){
                            
                          getUser();

                        }else{
                            alert(response.data);
                        }
                }).catch((error) => {
                    alert(error.data);
                    console.log(error);
                });
                
            } catch (error) {
                console.log(error);
            }

         }

         btnSetDrink.onclick =  async function(){
                      await sendCafe();
         }

         async function sendCafe(){

            try {
                    var id = document.getElementById('userId').value;
                    await fetch(`${Api_url}drink/setDrink/${id}`, {
                    method: "POST",
                    headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                }).then(response => response.json())
                    .then((response) => {
                        if(response.status == "sucess"){
                         var userAlterado =  response.data.user;
                         setDadosUser(userAlterado);
                         localStorage.setItem('user', JSON.stringify(userAlterado)); 

                         alert('café registrado!');

                        }else{
                            alert(response.data);
                        }
                }).catch((error) => {
                    alert(error.data);
                    console.log(error);
                });
                
            } catch (error) {
                console.log(error);
            }


        }

        btnDelete.onclick =  async function(){

            if(window.confirm("Você realmente quer Deleta?")){
                await deleteUser();
            }

         }

        async function deleteUser(){

                    try {
                            var id = document.getElementById('userId').value;
                            await fetch(`${Api_url}/user/delete/${id}`, {
                            method: "POST",
                            headers: {
                                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                            },
                        }).then(response => response.json())
                            .then((response) => {
                                if(response.status == "sucess"){
                                localStorage.removeItem('user');
                                localStorage.removeItem('token');
                                alert(response.data);

                                window.location = url+'painel.html';
                    
                                }else{
                                    alert(response.data);
                                }
                        }).catch((error) => {
                            alert(error.data);
                            console.log(error);
                        });
                        
                    } catch (error) {
                        console.log(error);
                    }

        }


        btnSair.onclick =  async function(){

            if(window.confirm("Você realmente quer Sair?")){
                localStorage.removeItem('user');
                localStorage.removeItem('token');
                window.location = url+'painel.html';
            }

        }



    </script>
</body>
</html>