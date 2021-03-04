<template>
  <main class="main">
    <div class="container-fluid">
      <div class="animated fadeIn">
        <div class="card">
          <div class="card-header">
            <i class="fa fa-align-justify"></i>{{ nombre_vista }}
            <button
              type="button"
              class="btn btn-success"
              @click="descargar_excel()"
            >
              Excel
              <i class="fas fa-file-excel"></i>&nbsp;
            </button>
            <button
              type="button"
              data-toggle="modal"
              data-target="#Modal_1"
              class="btn btn-secondary float-right ml-1"
              @click="abrirModal(0)"
            >
              <i class="fas fa-plus"></i>&nbsp;Nuevo
            </button>
          </div>
          <div class="card-body">
            <div class="form-group row">
              <div class="input-group">
                <select
                  class="form-control col-md-4"
                  v-model="opcion"
                  @focus="listar(1, buscar)"
                >
                  <option value="clientes.nombre">Nombre</option>
                  <option value="clientes.apellidos">Apellido</option>
                  <option value="clientes.edad">Edad</option>
                  <option value="clientes.correo">Correo</option>
                  <option value="clientes.nacionalidad">Nacionalidad</option>
                  <option value="clientes.ci">CI</option>
                  <option value="clientes.telefono">Telefono</option>
                  <option value="clientes.empresa">Empresa</option>
                </select>
                <input
                  type="text"
                  v-model="buscar"
                  @keyup="listar(1, buscar)"
                  class="form-control"
                  placeholder="Buscar..."
                />
                <button
                  type="submit"
                  @click="listar(1, buscar)"
                  class="btn btn-primary"
                >
                  <i class="fa fa-search"></i> Buscar
                </button>
              </div>
            </div>
            <table class="table table-bordered table-striped table-sm">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Apellidos</th>
                  <th>Edad</th>
                  <th>Correo</th>
                  <th>Nacionalidad</th>
                  <th>CI</th>
                  <th>Telefono</th>
                  <th>Empresa</th>
                  <th>Estado</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="datos in array_datos" :key="datos.id">
                  <td v-text="datos.nombre"></td>
                  <td v-text="datos.apellidos"></td>
                  <td v-text="datos.edad"></td>
                  <td v-text="datos.correo"></td>
                  <td v-text="datos.nacionalidad"></td>
                  <td v-text="datos.ci"></td>
                  <td v-text="datos.telefono"></td>
                  <td v-text="datos.empresa"></td>
                  <td>
                    <div v-if="datos.estado">
                      <span class="badge badge-success">Activo</span>
                    </div>
                    <div v-else>
                      <span class="badge badge-danger">Desactivado</span>
                    </div>
                  </td>
                  <td>
                    <button
                      type="button"
                      data-toggle="modal"
                      data-target="#Modal_1"
                      class="btn btn-warning btn-sm"
                      @click="abrirModal(1, datos)"
                    >
                      <i class="fas fa-pencil-alt"></i>
                    </button>
                    &nbsp;
                    <template v-if="datos.estado">
                      <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        @click="desactivar(datos.id)"
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                    </template>
                    <template v-else>
                      <button
                        type="button"
                        class="btn btn-success btn-sm"
                        @click="activar(datos.id)"
                      >
                        <i class="fas fa-check"></i>
                      </button>
                    </template>
                  </td>
                </tr>
              </tbody>
            </table>
            <nav>
              <ul class="pagination">
                <li class="page-item" v-if="pagination.current_page > 1">
                  <a
                    class="page-link"
                    href="#"
                    @click.prevent="
                      cambiarPagina(pagination.current_page - 1, buscar)
                    "
                    >Ant</a
                  >
                </li>
                <li
                  class="page-item"
                  v-for="page in pagesNumber"
                  :key="page"
                  :class="[page == isActived ? 'active' : '']"
                >
                  <a
                    class="page-link"
                    href="#"
                    @click.prevent="cambiarPagina(page, buscar)"
                    v-text="page"
                  ></a>
                </li>
                <li
                  class="page-item"
                  v-if="pagination.current_page < pagination.last_page"
                >
                  <a
                    class="page-link"
                    href="#"
                    @click.prevent="
                      cambiarPagina(pagination.current_page + 1, buscar)
                    "
                    >Sig</a
                  >
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
      <div
        class="modal fade"
        tabindex="-1"
        role="dialog"
        aria-labelledby="myModalLabel"
        id="Modal_1"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-primary modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{ tituloVentana }}</h4>
              <button
                class="close"
                type="button"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Nombre</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="nombre"
                    placeholder="Nombre..."
                    class="form-control"
                    @keyup.enter="insertar()"
                    required
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Apellidos</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="apellidos"
                    placeholder="Apellidos..."
                    class="form-control"
                    @keyup.enter="insertar()"
                    required
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Edad</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="edad"
                    placeholder="Edad..."
                    class="form-control"
                    @keyup.enter="insertar()"
                    required
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Correo</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="correo"
                    placeholder="Correo..."
                    class="form-control"
                    @keyup.enter="insertar()"
                    required
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Nacionalidad</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="nacionalidad"
                    placeholder="Nacionalidad..."
                    class="form-control"
                    @keyup.enter="insertar()"
                    required
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >CI</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="ci"
                    placeholder="CI..."
                    class="form-control"
                    @keyup.enter="insertar()"
                    required
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Telefono</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="telefono"
                    placeholder="Telefono..."
                    class="form-control"
                    @keyup.enter="insertar()"
                    required
                  />
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input"
                  >Empresa</label
                >
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="empresa"
                    placeholder="Empresa..."
                    class="form-control"
                    @keyup.enter="insertar()"
                    required
                  />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                class="btn btn-secondary"
                type="button"
                data-dismiss="modal"
              >
                Cerrar
              </button>
              <button
                class="btn btn-primary"
                type="button"
                v-if="accion == 0"
                @click="registrar()"
              >
                Guardar
              </button>
              <button
                class="btn btn-primary"
                type="button"
                v-else
                @click="actualizar()"
              >
                Actualizar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return {
      nombre_vista: "Clientes",
      opcion: "clientes.nombre",
      buscar: "",
      array_datos: [],
      tituloVentana: "",
      offset: 3,
      accion: 0,
      id: 0,
      nombre: "",
      apellidos: "",
      edad: "",
      correo: "",
      nacionalidad: "",
      ci: "",
      telefono: "",
      empresa: "",
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0,
      },
    };
  },
  mounted() {
    this.listar(1, this.buscar);
  },

  computed: {
    isActived: function () {
      return this.pagination.current_page;
    },
    //Calcula los elementos de la paginación
    pagesNumber: function () {
      if (!this.pagination.to) {
        return [];
      }

      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      var to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    },
  },

  methods: {
    insertar() {
      if (this.accion == 0) {
        this.registrar();
      } else {
        this.actualizar();
      }
    },
    descargar_excel() {
      window.open(
        '/cliente/excel'
      );
    },
    limpiar() {
      this.id = 0;
      this.buscar = "";
      this.nombre = "";
      this.apellidos = "";
      this.edad = "";
      this.correo = "";
      this.nacionalidad = "";
      this.ci = "";
      this.telefono = "";
      this.empresa = "";
    },
    cambiarPagina(page, buscar) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listar(page, buscar);
    },
    abrirModal(accion, data = []) {
      switch (accion) {
        case 0: {
          this.tituloVentana = "Agregar " + this.nombre_vista;
          this.limpiar();
          this.accion = 0;
          break;
        }
        case 1: {
          this.tituloVentana = "Actualizar " + this.nombre_vista;
          this.nombre = data.nombre;
          this.id = data.id;
          this.accion = 1;
          this.apellidos = data.apellidos;
          this.edad = data.edad;
          this.correo = data.correo;
          this.nacionalidad = data.nacionalidad;
          this.ci = data.ci;
          this.telefono = data.telefono;
          this.empresa = data.empresa;
          break;
        }
      }
    },
    listar(page, buscar) {
      let me = this;
      let url =
        "/cliente?page=" +
        page +
        "&opcion=" +
        this.opcion +
        "&buscar=" +
        buscar;
      axios
        .get(url)
        .then(function (response) {
          let respuesta = response.data;
          me.array_datos = respuesta.clientes.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    registrar() {
      let me = this;
      axios
        .post("/cliente/registrar", {
          nombre: this.nombre,
          apellidos: this.apellidos,
          edad: this.edad,
          correo: this.correo,
          nacionalidad: this.nacionalidad,
          ci: this.ci,
          telefono: this.telefono,
          empresa: this.empresa,
        })
        .then(function (response) {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Agregado con exito!",
            showConfirmButton: false,
            timer: 1500,
          });
          $("#Modal_1").modal("hide");
          me.listar(1, "");
        })
        .catch(function (error) {
          Swal.fire({
            position: "center",
            icon: "warning",
            title: "Error (" + error.status + "): " + error,
          });
        });
    },
    actualizar() {
      let me = this;
      axios
        .put("/cliente/actualizar", {
          id: this.id,
          nombre: this.nombre,
          apellidos: this.apellidos,
          edad: this.edad,
          correo: this.correo,
          nacionalidad: this.nacionalidad,
          ci: this.ci,
          telefono: this.telefono,
          empresa: this.empresa,
        })
        .then(function (response) {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Actualizado con exito!",
            showConfirmButton: false,
            timer: 1500,
          });
          $("#Modal_1").modal("hide");
          me.listar(1, "");
        })
        .catch(function (error) {
          Swal.fire({
            position: "center",
            icon: "warning",
            title: "Error (" + error.status + "): " + error,
          });
        });
    },
    activar(id) {
      Swal.fire({
        title: "Esta seguro de recuperar el registro?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar!",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true,
      }).then((result) => {
        if (result.value) {
          let me = this;
          axios
            .put("/cliente/activar", {
              id: id,
            })
            .then(function (response) {
              me.listar(1, "", "nombre");
              Swal.fire({
                title: "Recuperado!",
                text: "El registro ha sido recuperado con éxito.",
                icon: "success",
                showConfirmButton: false,
                timer: 1500,
              });
            })
            .catch(function (error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === Swal.DismissReason.cancel
        ) {
        }
      });
    },
    desactivar(id) {
      Swal.fire({
        title: "Esta seguro de desactivar registro?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar!",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true,
      }).then((result) => {
        if (result.value) {
          let me = this;
          axios
            .put("/cliente/desactivar", {
              id: id,
            })
            .then(function (response) {
              me.listar(1, "", "nombre");
              Swal.fire({
                title: "Desactivado!",
                text: "El registro ha sido desactivado con éxito.",
                icon: "success",
                showConfirmButton: false,
                timer: 1500,
              });
            })
            .catch(function (error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === Swal.DismissReason.cancel
        ) {
        }
      });
    },
  },
};
</script>
