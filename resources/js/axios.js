// // resources/js/axios.js

// import axios from 'axios';

// axios.defaults.baseURL = 'http://localhost:8000'; // Ajusta la URL base según tu configuración

// // Configurar interceptor para incluir el token en cada solicitud
// axios.interceptors.request.use(
//   (config) => {
//     const token = localStorage.getItem('token');
//     if (token) {
//       config.headers['Authorization'] = `Bearer ${token}`;
//     }
//     return config;
//   },
//   (error) => Promise.reject(error)
// );

// export default axios;
