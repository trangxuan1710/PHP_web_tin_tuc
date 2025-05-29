window.commentApp = function(newsId) {
    return {
        comments: window.__COMMENTS,
        replyTo: null,

        startReply(id) {
            this.replyTo = id;
        },

        renderComment(comment) {
            let html = `
                <div class="ml-4 mt-2 border-l-2 pl-3">
                    <strong>${comment.client.name}</strong>: ${comment.content}
                    <div class="text-sm mt-1 space-x-2">
                        <button onclick="like(${comment.id})">👍 ${comment.like_count}</button>
                        <button onclick="dislike(${comment.id})">👎 ${comment.dislike_count}</button>
                        <button onclick="report(${comment.id})">🚩 ${comment.report_count}</button>
                        <button onclick="Alpine.store('reply').start(${comment.id})" class="text-blue-500">Phản hồi</button>
                    </div>
            `;

            if (comment.replies?.length) {
                html += `<div class="ml-4">`;
                for (let reply of comment.replies) {
                    html += this.renderComment(reply);
                }
                html += `</div>`;
            }

            html += `</div>`;
            return html;
        }
    };
};

function commentApp(newsId) {
    return {
        comments: window.__COMMENTS,
        replyTo: null,

        startReply(id) {
            this.replyTo = id;
        },

        like(id) {
            fetch(`/comments/${id}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(res => res.json())
                .then(data => this.updateCount(id, 'like_count', data.like_count));
        },

        dislike(id) {
            fetch(`/comments/${id}/dislike`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(res => res.json())
                .then(data => this.updateCount(id, 'dislike_count', data.dislike_count));
        },

        report(id) {
            fetch(`/comments/${id}/report`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(res => res.json())
                .then(data => this.updateCount(id, 'report_count', data.report_count));
        },

        updateCount(id, field, value) {
            const updateRecursive = (list) => {
                for (let item of list) {
                    if (item.id === id) {
                        item[field] = value;
                        return true;
                    }
                    if (item.replies && updateRecursive(item.replies)) {
                        return true;
                    }
                }
                return false;
            };
            updateRecursive(this.comments);
        }
    };
}
