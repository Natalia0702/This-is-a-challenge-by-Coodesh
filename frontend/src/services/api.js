import { toast } from '@/helpers/toast'

export const getBaseUrl = () => {
    let baseUrl = 'http://localhost:8000/api';
    return (`${baseUrl}`).replace(/\/$/, '');
}

export const getUrl = (path) => {
    let baseUrl = getBaseUrl();
    path = (` ${path} `).trim().replace(/^\/|\/$/g, '');

    return [
        baseUrl,
        path,
    ]
    .filter(item => item.trim())
    .join('/');
}

export const validateToken = async (actions) => {
    let actionsEvent = {
        onFail: actions?.onFail,
        onEmpty: actions?.onEmpty,
        onSuccess: actions?.onSuccess,
        onError: actions?.onError,
    }
    let token = localStorage.getItem('token');

    let isFunction = (item) => {
        return !!(item && item.constructor && (item.constructor.name == 'Function'));
    }

    if (!token) {
        isFunction(actionsEvent.onEmpty) && actionsEvent?.onEmpty();

        return;
    }

    let url = getUrl('/auth/me');

    fetch(url, {
        headers: {
            Accept: 'application/json',
            Authorization: `Bearer ${token}`,
        }
    })
        .then(response => {
            if (!response.ok) {
                localStorage.removeItem('token');
                isFunction(actionsEvent.onFail) && actionsEvent?.onFail();

                return ({
                    error: 'Invalid credentials',
                    action: {
                        type: 'redirect',
                        data: 'login',
                    }
                });
            }

            return response.json();
        })
        .then(async (data) => {
            isFunction(actionsEvent.onSuccess) && actionsEvent?.onSuccess(data);
        })
        .catch(error => {
            isFunction(actionsEvent.onError) && actionsEvent?.onError(error);
            console.error(error)
        })
}

export const isAuthenticated = async () => {
    await validateToken({
        onFail: () => {
            toast.error('onFail');
        },
        onEmpty: () => {
            // toast.error('onEmpty');
        },
        onError: () => {
            toast.error('onError');
        },
    });

    const token = localStorage.getItem('token');
    return !!token;
};
