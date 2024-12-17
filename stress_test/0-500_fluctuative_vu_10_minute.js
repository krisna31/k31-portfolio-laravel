import http from 'k6/http';
import { sleep } from 'k6';

export const options = {
    stages: [
        { duration: '2m', target: 500 },
        { duration: '1m', target: 300 },
        { duration: '2m', target: 150 },
        { duration: '4m', target: 320 },
        { duration: '30s', target: 180 },
        { duration: '30s', target: 0 },
    ],
};

export default () => {
    const urlRes = http.get('https://yoklah.absen.k31.my.id/');
    sleep(1);
};
