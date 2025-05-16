# Service Provider Directory

## Design Decisions
- Eloquent relationships with `with()` to prevent N+1 queries
- Pagination to limit DOM and payload

## Performance Optimizations
- **Lazy-loaded images**: `loading="lazy"` + `srcset`
- **Deferred JS/CSS splitting**: critical CSS inlined, rest deferred via Mix
- **HTTP caching**: leverage Laravel’s cache headers + CDN
- **Eager loading**: all provider listings load category in one query

## Future Enhancements
- Implement client-side filtering with a tiny Vue component
- Add Redis caching on listings endpoint
- Introduce SSR or static page generation for top categories
