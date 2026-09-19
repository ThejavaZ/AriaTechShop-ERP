// DVLJ_prueba.js
// Responsable: Dávila Villa Laura Jacqueline (@a23311069)
// Módulo: Inventario
// Endpoint: GET /inventory

import http from 'k6/http';
import { check, sleep } from 'k6';
import { Trend } from 'k6/metrics';

const endpointDuration = new Trend('endpoint_duration');

export const options = {
  vus: 5,
  duration: '30s',
  thresholds: {
    'http_req_duration': ['p(95)<5000'], // p95 < 5s
  },
};

const BASE_URL = 'http://127.0.0.1:8000';

const USER = {
  email: 'admin@ariatechshop.com',
  password: 'password',
};

export default function () {
  // 1. GET a la página de login para obtener el token CSRF y la cookie de sesión
  const loginPage = http.get(`${BASE_URL}/auth/login`);

  const csrfMatch = loginPage.body.match(/name="_token" value="([^"]+)"/);
  const csrfToken = csrfMatch ? csrfMatch[1] : null;

  // 2. POST de login incluyendo el token CSRF
  const loginRes = http.post(`${BASE_URL}/auth/store`, {
    email: USER.email,
    password: USER.password,
    _token: csrfToken,
  });

  check(loginRes, {
    'login exitoso (status 200-302)': (r) => r.status === 200 || r.status === 302,
  });

  // 3. Petición al endpoint de Inventario
  const res = http.get(`${BASE_URL}/inventory`);

  endpointDuration.add(res.timings.duration);

  check(res, {
    'status es 200': (r) => r.status === 200,
    'no contiene formulario de login': (r) => !r.body.includes('type="password"'),
    'contiene contenido de Inventario': (r) => r.body.includes('Inventario'),
    'respuesta en menos de 5s': (r) => r.timings.duration < 5000,
  });

  sleep(1);
}